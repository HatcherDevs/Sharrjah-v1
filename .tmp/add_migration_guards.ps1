$files = Get-ChildItem database/migrations -File -Filter *.php
$updated = 0

function Get-MethodBlock {
    param([string]$Content, [string]$MethodName)

    $regex = [regex]::new("public\s+function\s+$MethodName\s*\([^\)]*\)\s*(?::\s*void)?\s*\{", [System.Text.RegularExpressions.RegexOptions]::IgnoreCase)
    $m = $regex.Match($Content)
    if (-not $m.Success) { return $null }

    $braceStart = $Content.IndexOf('{', $m.Index)
    if ($braceStart -lt 0) { return $null }

    $depth = 0
    $endIndex = -1
    for ($i = $braceStart; $i -lt $Content.Length; $i++) {
        if ($Content[$i] -eq '{') { $depth++ }
        elseif ($Content[$i] -eq '}') {
            $depth--
            if ($depth -eq 0) { $endIndex = $i; break }
        }
    }
    if ($endIndex -lt 0) { return $null }

    return [PSCustomObject]@{
        BodyStart = $braceStart + 1
        EndIndex = $endIndex
        BodyLength = $endIndex - ($braceStart + 1)
    }
}

function Add-Guard {
    param([string]$Content, [string]$MethodName)

    $block = Get-MethodBlock -Content $Content -MethodName $MethodName
    if (-not $block) { return [PSCustomObject]@{ Content = $Content; Changed = $false } }

    $body = $Content.Substring($block.BodyStart, $block.BodyLength)
    if ($body -match 'Schema::hasTable\(' -or $body -match 'Schema::hasColumn\(') {
        return [PSCustomObject]@{ Content = $Content; Changed = $false }
    }

    $createMatch = [regex]::Match($body, "Schema::create\('([^']+)'")
    $tableMatch = [regex]::Match($body, "Schema::table\('([^']+)'")
    $dropMatch = [regex]::Match($body, "Schema::drop\('([^']+)'")

    $guard = $null

    if ($MethodName -eq 'up') {
        if ($createMatch.Success) {
            $table = $createMatch.Groups[1].Value
            $guard = "`r`n        if (Schema::hasTable('$table')) {`r`n            return;`r`n        }`r`n"
        } elseif ($tableMatch.Success) {
            $table = $tableMatch.Groups[1].Value
            $guard = "`r`n        if (!Schema::hasTable('$table')) {`r`n            return;`r`n        }`r`n"
        }
    } elseif ($MethodName -eq 'down') {
        if ($tableMatch.Success) {
            $table = $tableMatch.Groups[1].Value
            $guard = "`r`n        if (!Schema::hasTable('$table')) {`r`n            return;`r`n        }`r`n"
        } elseif ($dropMatch.Success) {
            $table = $dropMatch.Groups[1].Value
            $guard = "`r`n        if (!Schema::hasTable('$table')) {`r`n            return;`r`n        }`r`n"
        }
    }

    if (-not $guard) { return [PSCustomObject]@{ Content = $Content; Changed = $false } }

    $newBody = $guard + $body
    $newContent = $Content.Substring(0, $block.BodyStart) + $newBody + $Content.Substring($block.EndIndex)
    return [PSCustomObject]@{ Content = $newContent; Changed = $true }
}

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw
    $original = $content

    $r1 = Add-Guard -Content $content -MethodName 'up'
    $content = $r1.Content

    $r2 = Add-Guard -Content $content -MethodName 'down'
    $content = $r2.Content

    if ($content -ne $original) {
        Set-Content -Path $file.FullName -Value $content -NoNewline
        $updated++
    }
}

$withHasTable = ($files | Select-String -Pattern 'Schema::hasTable\(' -List).Count
Write-Output "Updated migrations: $updated"
Write-Output "Files with hasTable: $withHasTable / $($files.Count)"