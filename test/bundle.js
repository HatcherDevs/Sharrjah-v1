
(function(l, r) { if (!l || l.getElementById('livereloadscript')) return; r = l.createElement('script'); r.async = 1; r.src = '//' + (self.location.host || 'localhost').split(':')[0] + ':35730/livereload.js?snipver=1'; r.id = 'livereloadscript'; l.getElementsByTagName('head')[0].appendChild(r) })(self.document);
var app = (function () {
    'use strict';

    function noop$1() { }
    const identity$6 = x => x;
    function assign(tar, src) {
        // @ts-ignore
        for (const k in src)
            tar[k] = src[k];
        return tar;
    }
    // Adapted from https://github.com/then/is-promise/blob/master/index.js
    // Distributed under MIT License https://github.com/then/is-promise/blob/master/LICENSE
    function is_promise(value) {
        return !!value && (typeof value === 'object' || typeof value === 'function') && typeof value.then === 'function';
    }
    function run(fn) {
        return fn();
    }
    function blank_object() {
        return Object.create(null);
    }
    function run_all(fns) {
        fns.forEach(run);
    }
    function is_function(thing) {
        return typeof thing === 'function';
    }
    function safe_not_equal(a, b) {
        return a != a ? b == b : a !== b || ((a && typeof a === 'object') || typeof a === 'function');
    }
    let src_url_equal_anchor;
    function src_url_equal(element_src, url) {
        if (!src_url_equal_anchor) {
            src_url_equal_anchor = document.createElement('a');
        }
        src_url_equal_anchor.href = url;
        return element_src === src_url_equal_anchor.href;
    }
    function is_empty(obj) {
        return Object.keys(obj).length === 0;
    }
    function subscribe(store, ...callbacks) {
        if (store == null) {
            return noop$1;
        }
        const unsub = store.subscribe(...callbacks);
        return unsub.unsubscribe ? () => unsub.unsubscribe() : unsub;
    }
    function component_subscribe(component, store, callback) {
        component.$$.on_destroy.push(subscribe(store, callback));
    }
    function create_slot(definition, ctx, $$scope, fn) {
        if (definition) {
            const slot_ctx = get_slot_context(definition, ctx, $$scope, fn);
            return definition[0](slot_ctx);
        }
    }
    function get_slot_context(definition, ctx, $$scope, fn) {
        return definition[1] && fn
            ? assign($$scope.ctx.slice(), definition[1](fn(ctx)))
            : $$scope.ctx;
    }
    function get_slot_changes(definition, $$scope, dirty, fn) {
        if (definition[2] && fn) {
            const lets = definition[2](fn(dirty));
            if ($$scope.dirty === undefined) {
                return lets;
            }
            if (typeof lets === 'object') {
                const merged = [];
                const len = Math.max($$scope.dirty.length, lets.length);
                for (let i = 0; i < len; i += 1) {
                    merged[i] = $$scope.dirty[i] | lets[i];
                }
                return merged;
            }
            return $$scope.dirty | lets;
        }
        return $$scope.dirty;
    }
    function update_slot_base(slot, slot_definition, ctx, $$scope, slot_changes, get_slot_context_fn) {
        if (slot_changes) {
            const slot_context = get_slot_context(slot_definition, ctx, $$scope, get_slot_context_fn);
            slot.p(slot_context, slot_changes);
        }
    }
    function get_all_dirty_from_scope($$scope) {
        if ($$scope.ctx.length > 32) {
            const dirty = [];
            const length = $$scope.ctx.length / 32;
            for (let i = 0; i < length; i++) {
                dirty[i] = -1;
            }
            return dirty;
        }
        return -1;
    }
    function exclude_internal_props(props) {
        const result = {};
        for (const k in props)
            if (k[0] !== '$')
                result[k] = props[k];
        return result;
    }
    function action_destroyer(action_result) {
        return action_result && is_function(action_result.destroy) ? action_result.destroy : noop$1;
    }
    function split_css_unit(value) {
        const split = typeof value === 'string' && value.match(/^\s*(-?[\d.]+)([^\s]*)\s*$/);
        return split ? [parseFloat(split[1]), split[2] || 'px'] : [value, 'px'];
    }

    const is_client = typeof window !== 'undefined';
    let now$2 = is_client
        ? () => window.performance.now()
        : () => Date.now();
    let raf = is_client ? cb => requestAnimationFrame(cb) : noop$1;

    const tasks = new Set();
    function run_tasks(now) {
        tasks.forEach(task => {
            if (!task.c(now)) {
                tasks.delete(task);
                task.f();
            }
        });
        if (tasks.size !== 0)
            raf(run_tasks);
    }
    /**
     * Creates a new task that runs on each raf frame
     * until it returns a falsy value or is aborted
     */
    function loop(callback) {
        let task;
        if (tasks.size === 0)
            raf(run_tasks);
        return {
            promise: new Promise(fulfill => {
                tasks.add(task = { c: callback, f: fulfill });
            }),
            abort() {
                tasks.delete(task);
            }
        };
    }
    function append(target, node) {
        target.appendChild(node);
    }
    function get_root_for_style(node) {
        if (!node)
            return document;
        const root = node.getRootNode ? node.getRootNode() : node.ownerDocument;
        if (root && root.host) {
            return root;
        }
        return node.ownerDocument;
    }
    function append_empty_stylesheet(node) {
        const style_element = element('style');
        append_stylesheet(get_root_for_style(node), style_element);
        return style_element.sheet;
    }
    function append_stylesheet(node, style) {
        append(node.head || node, style);
        return style.sheet;
    }
    function insert(target, node, anchor) {
        target.insertBefore(node, anchor || null);
    }
    function detach(node) {
        if (node.parentNode) {
            node.parentNode.removeChild(node);
        }
    }
    function destroy_each(iterations, detaching) {
        for (let i = 0; i < iterations.length; i += 1) {
            if (iterations[i])
                iterations[i].d(detaching);
        }
    }
    function element(name) {
        return document.createElement(name);
    }
    function svg_element(name) {
        return document.createElementNS('http://www.w3.org/2000/svg', name);
    }
    function text(data) {
        return document.createTextNode(data);
    }
    function space() {
        return text(' ');
    }
    function empty() {
        return text('');
    }
    function listen$1(node, event, handler, options) {
        node.addEventListener(event, handler, options);
        return () => node.removeEventListener(event, handler, options);
    }
    function attr(node, attribute, value) {
        if (value == null)
            node.removeAttribute(attribute);
        else if (node.getAttribute(attribute) !== value)
            node.setAttribute(attribute, value);
    }
    function children(element) {
        return Array.from(element.childNodes);
    }
    function set_data(text, data) {
        data = '' + data;
        if (text.data === data)
            return;
        text.data = data;
    }
    function set_style(node, key, value, important) {
        if (value === null) {
            node.style.removeProperty(key);
        }
        else {
            node.style.setProperty(key, value, important ? 'important' : '');
        }
    }
    function toggle_class(element, name, toggle) {
        element.classList[toggle ? 'add' : 'remove'](name);
    }
    function custom_event(type, detail, { bubbles = false, cancelable = false } = {}) {
        const e = document.createEvent('CustomEvent');
        e.initCustomEvent(type, bubbles, cancelable, detail);
        return e;
    }
    class HtmlTag {
        constructor(is_svg = false) {
            this.is_svg = false;
            this.is_svg = is_svg;
            this.e = this.n = null;
        }
        c(html) {
            this.h(html);
        }
        m(html, target, anchor = null) {
            if (!this.e) {
                if (this.is_svg)
                    this.e = svg_element(target.nodeName);
                /** #7364  target for <template> may be provided as #document-fragment(11) */
                else
                    this.e = element((target.nodeType === 11 ? 'TEMPLATE' : target.nodeName));
                this.t = target.tagName !== 'TEMPLATE' ? target : target.content;
                this.c(html);
            }
            this.i(anchor);
        }
        h(html) {
            this.e.innerHTML = html;
            this.n = Array.from(this.e.nodeName === 'TEMPLATE' ? this.e.content.childNodes : this.e.childNodes);
        }
        i(anchor) {
            for (let i = 0; i < this.n.length; i += 1) {
                insert(this.t, this.n[i], anchor);
            }
        }
        p(html) {
            this.d();
            this.h(html);
            this.i(this.a);
        }
        d() {
            this.n.forEach(detach);
        }
    }
    function construct_svelte_component(component, props) {
        return new component(props);
    }

    // we need to store the information for multiple documents because a Svelte application could also contain iframes
    // https://github.com/sveltejs/svelte/issues/3624
    const managed_styles = new Map();
    let active = 0;
    // https://github.com/darkskyapp/string-hash/blob/master/index.js
    function hash(str) {
        let hash = 5381;
        let i = str.length;
        while (i--)
            hash = ((hash << 5) - hash) ^ str.charCodeAt(i);
        return hash >>> 0;
    }
    function create_style_information(doc, node) {
        const info = { stylesheet: append_empty_stylesheet(node), rules: {} };
        managed_styles.set(doc, info);
        return info;
    }
    function create_rule(node, a, b, duration, delay, ease, fn, uid = 0) {
        const step = 16.666 / duration;
        let keyframes = '{\n';
        for (let p = 0; p <= 1; p += step) {
            const t = a + (b - a) * ease(p);
            keyframes += p * 100 + `%{${fn(t, 1 - t)}}\n`;
        }
        const rule = keyframes + `100% {${fn(b, 1 - b)}}\n}`;
        const name = `__svelte_${hash(rule)}_${uid}`;
        const doc = get_root_for_style(node);
        const { stylesheet, rules } = managed_styles.get(doc) || create_style_information(doc, node);
        if (!rules[name]) {
            rules[name] = true;
            stylesheet.insertRule(`@keyframes ${name} ${rule}`, stylesheet.cssRules.length);
        }
        const animation = node.style.animation || '';
        node.style.animation = `${animation ? `${animation}, ` : ''}${name} ${duration}ms linear ${delay}ms 1 both`;
        active += 1;
        return name;
    }
    function delete_rule(node, name) {
        const previous = (node.style.animation || '').split(', ');
        const next = previous.filter(name
            ? anim => anim.indexOf(name) < 0 // remove specific animation
            : anim => anim.indexOf('__svelte') === -1 // remove all Svelte animations
        );
        const deleted = previous.length - next.length;
        if (deleted) {
            node.style.animation = next.join(', ');
            active -= deleted;
            if (!active)
                clear_rules();
        }
    }
    function clear_rules() {
        raf(() => {
            if (active)
                return;
            managed_styles.forEach(info => {
                const { ownerNode } = info.stylesheet;
                // there is no ownerNode if it runs on jsdom.
                if (ownerNode)
                    detach(ownerNode);
            });
            managed_styles.clear();
        });
    }

    let current_component;
    function set_current_component(component) {
        current_component = component;
    }
    function get_current_component() {
        if (!current_component)
            throw new Error('Function called outside component initialization');
        return current_component;
    }
    /**
     * The `onMount` function schedules a callback to run as soon as the component has been mounted to the DOM.
     * It must be called during the component's initialisation (but doesn't need to live *inside* the component;
     * it can be called from an external module).
     *
     * `onMount` does not run inside a [server-side component](/docs#run-time-server-side-component-api).
     *
     * https://svelte.dev/docs#run-time-svelte-onmount
     */
    function onMount(fn) {
        get_current_component().$$.on_mount.push(fn);
    }
    /**
     * Schedules a callback to run immediately before the component is unmounted.
     *
     * Out of `onMount`, `beforeUpdate`, `afterUpdate` and `onDestroy`, this is the
     * only one that runs inside a server-side component.
     *
     * https://svelte.dev/docs#run-time-svelte-ondestroy
     */
    function onDestroy(fn) {
        get_current_component().$$.on_destroy.push(fn);
    }
    /**
     * Associates an arbitrary `context` object with the current component and the specified `key`
     * and returns that object. The context is then available to children of the component
     * (including slotted content) with `getContext`.
     *
     * Like lifecycle functions, this must be called during component initialisation.
     *
     * https://svelte.dev/docs#run-time-svelte-setcontext
     */
    function setContext(key, context) {
        get_current_component().$$.context.set(key, context);
        return context;
    }
    /**
     * Retrieves the context that belongs to the closest parent component with the specified `key`.
     * Must be called during component initialisation.
     *
     * https://svelte.dev/docs#run-time-svelte-getcontext
     */
    function getContext(key) {
        return get_current_component().$$.context.get(key);
    }

    const dirty_components = [];
    const binding_callbacks = [];
    let render_callbacks = [];
    const flush_callbacks = [];
    const resolved_promise = /* @__PURE__ */ Promise.resolve();
    let update_scheduled = false;
    function schedule_update() {
        if (!update_scheduled) {
            update_scheduled = true;
            resolved_promise.then(flush);
        }
    }
    function add_render_callback(fn) {
        render_callbacks.push(fn);
    }
    // flush() calls callbacks in this order:
    // 1. All beforeUpdate callbacks, in order: parents before children
    // 2. All bind:this callbacks, in reverse order: children before parents.
    // 3. All afterUpdate callbacks, in order: parents before children. EXCEPT
    //    for afterUpdates called during the initial onMount, which are called in
    //    reverse order: children before parents.
    // Since callbacks might update component values, which could trigger another
    // call to flush(), the following steps guard against this:
    // 1. During beforeUpdate, any updated components will be added to the
    //    dirty_components array and will cause a reentrant call to flush(). Because
    //    the flush index is kept outside the function, the reentrant call will pick
    //    up where the earlier call left off and go through all dirty components. The
    //    current_component value is saved and restored so that the reentrant call will
    //    not interfere with the "parent" flush() call.
    // 2. bind:this callbacks cannot trigger new flush() calls.
    // 3. During afterUpdate, any updated components will NOT have their afterUpdate
    //    callback called a second time; the seen_callbacks set, outside the flush()
    //    function, guarantees this behavior.
    const seen_callbacks = new Set();
    let flushidx = 0; // Do *not* move this inside the flush() function
    function flush() {
        // Do not reenter flush while dirty components are updated, as this can
        // result in an infinite loop. Instead, let the inner flush handle it.
        // Reentrancy is ok afterwards for bindings etc.
        if (flushidx !== 0) {
            return;
        }
        const saved_component = current_component;
        do {
            // first, call beforeUpdate functions
            // and update components
            try {
                while (flushidx < dirty_components.length) {
                    const component = dirty_components[flushidx];
                    flushidx++;
                    set_current_component(component);
                    update(component.$$);
                }
            }
            catch (e) {
                // reset dirty state to not end up in a deadlocked state and then rethrow
                dirty_components.length = 0;
                flushidx = 0;
                throw e;
            }
            set_current_component(null);
            dirty_components.length = 0;
            flushidx = 0;
            while (binding_callbacks.length)
                binding_callbacks.pop()();
            // then, once components are updated, call
            // afterUpdate functions. This may cause
            // subsequent updates...
            for (let i = 0; i < render_callbacks.length; i += 1) {
                const callback = render_callbacks[i];
                if (!seen_callbacks.has(callback)) {
                    // ...so guard against infinite loops
                    seen_callbacks.add(callback);
                    callback();
                }
            }
            render_callbacks.length = 0;
        } while (dirty_components.length);
        while (flush_callbacks.length) {
            flush_callbacks.pop()();
        }
        update_scheduled = false;
        seen_callbacks.clear();
        set_current_component(saved_component);
    }
    function update($$) {
        if ($$.fragment !== null) {
            $$.update();
            run_all($$.before_update);
            const dirty = $$.dirty;
            $$.dirty = [-1];
            $$.fragment && $$.fragment.p($$.ctx, dirty);
            $$.after_update.forEach(add_render_callback);
        }
    }
    /**
     * Useful for example to execute remaining `afterUpdate` callbacks before executing `destroy`.
     */
    function flush_render_callbacks(fns) {
        const filtered = [];
        const targets = [];
        render_callbacks.forEach((c) => fns.indexOf(c) === -1 ? filtered.push(c) : targets.push(c));
        targets.forEach((c) => c());
        render_callbacks = filtered;
    }

    let promise;
    function wait() {
        if (!promise) {
            promise = Promise.resolve();
            promise.then(() => {
                promise = null;
            });
        }
        return promise;
    }
    function dispatch(node, direction, kind) {
        node.dispatchEvent(custom_event(`${direction ? 'intro' : 'outro'}${kind}`));
    }
    const outroing = new Set();
    let outros;
    function group_outros() {
        outros = {
            r: 0,
            c: [],
            p: outros // parent group
        };
    }
    function check_outros() {
        if (!outros.r) {
            run_all(outros.c);
        }
        outros = outros.p;
    }
    function transition_in(block, local) {
        if (block && block.i) {
            outroing.delete(block);
            block.i(local);
        }
    }
    function transition_out(block, local, detach, callback) {
        if (block && block.o) {
            if (outroing.has(block))
                return;
            outroing.add(block);
            outros.c.push(() => {
                outroing.delete(block);
                if (callback) {
                    if (detach)
                        block.d(1);
                    callback();
                }
            });
            block.o(local);
        }
        else if (callback) {
            callback();
        }
    }
    const null_transition = { duration: 0 };
    function create_in_transition(node, fn, params) {
        const options = { direction: 'in' };
        let config = fn(node, params, options);
        let running = false;
        let animation_name;
        let task;
        let uid = 0;
        function cleanup() {
            if (animation_name)
                delete_rule(node, animation_name);
        }
        function go() {
            const { delay = 0, duration = 300, easing = identity$6, tick = noop$1, css } = config || null_transition;
            if (css)
                animation_name = create_rule(node, 0, 1, duration, delay, easing, css, uid++);
            tick(0, 1);
            const start_time = now$2() + delay;
            const end_time = start_time + duration;
            if (task)
                task.abort();
            running = true;
            add_render_callback(() => dispatch(node, true, 'start'));
            task = loop(now => {
                if (running) {
                    if (now >= end_time) {
                        tick(1, 0);
                        dispatch(node, true, 'end');
                        cleanup();
                        return running = false;
                    }
                    if (now >= start_time) {
                        const t = easing((now - start_time) / duration);
                        tick(t, 1 - t);
                    }
                }
                return running;
            });
        }
        let started = false;
        return {
            start() {
                if (started)
                    return;
                started = true;
                delete_rule(node);
                if (is_function(config)) {
                    config = config(options);
                    wait().then(go);
                }
                else {
                    go();
                }
            },
            invalidate() {
                started = false;
            },
            end() {
                if (running) {
                    cleanup();
                    running = false;
                }
            }
        };
    }

    function handle_promise(promise, info) {
        const token = info.token = {};
        function update(type, index, key, value) {
            if (info.token !== token)
                return;
            info.resolved = value;
            let child_ctx = info.ctx;
            if (key !== undefined) {
                child_ctx = child_ctx.slice();
                child_ctx[key] = value;
            }
            const block = type && (info.current = type)(child_ctx);
            let needs_flush = false;
            if (info.block) {
                if (info.blocks) {
                    info.blocks.forEach((block, i) => {
                        if (i !== index && block) {
                            group_outros();
                            transition_out(block, 1, 1, () => {
                                if (info.blocks[i] === block) {
                                    info.blocks[i] = null;
                                }
                            });
                            check_outros();
                        }
                    });
                }
                else {
                    info.block.d(1);
                }
                block.c();
                transition_in(block, 1);
                block.m(info.mount(), info.anchor);
                needs_flush = true;
            }
            info.block = block;
            if (info.blocks)
                info.blocks[index] = block;
            if (needs_flush) {
                flush();
            }
        }
        if (is_promise(promise)) {
            const current_component = get_current_component();
            promise.then(value => {
                set_current_component(current_component);
                update(info.then, 1, info.value, value);
                set_current_component(null);
            }, error => {
                set_current_component(current_component);
                update(info.catch, 2, info.error, error);
                set_current_component(null);
                if (!info.hasCatch) {
                    throw error;
                }
            });
            // if we previously had a then/catch block, destroy it
            if (info.current !== info.pending) {
                update(info.pending, 0);
                return true;
            }
        }
        else {
            if (info.current !== info.then) {
                update(info.then, 1, info.value, promise);
                return true;
            }
            info.resolved = promise;
        }
    }
    function update_await_block_branch(info, ctx, dirty) {
        const child_ctx = ctx.slice();
        const { resolved } = info;
        if (info.current === info.then) {
            child_ctx[info.value] = resolved;
        }
        if (info.current === info.catch) {
            child_ctx[info.error] = resolved;
        }
        info.block.p(child_ctx, dirty);
    }

    const globals = (typeof window !== 'undefined'
        ? window
        : typeof globalThis !== 'undefined'
            ? globalThis
            : global);
    function outro_and_destroy_block(block, lookup) {
        transition_out(block, 1, 1, () => {
            lookup.delete(block.key);
        });
    }
    function update_keyed_each(old_blocks, dirty, get_key, dynamic, ctx, list, lookup, node, destroy, create_each_block, next, get_context) {
        let o = old_blocks.length;
        let n = list.length;
        let i = o;
        const old_indexes = {};
        while (i--)
            old_indexes[old_blocks[i].key] = i;
        const new_blocks = [];
        const new_lookup = new Map();
        const deltas = new Map();
        const updates = [];
        i = n;
        while (i--) {
            const child_ctx = get_context(ctx, list, i);
            const key = get_key(child_ctx);
            let block = lookup.get(key);
            if (!block) {
                block = create_each_block(key, child_ctx);
                block.c();
            }
            else if (dynamic) {
                // defer updates until all the DOM shuffling is done
                updates.push(() => block.p(child_ctx, dirty));
            }
            new_lookup.set(key, new_blocks[i] = block);
            if (key in old_indexes)
                deltas.set(key, Math.abs(i - old_indexes[key]));
        }
        const will_move = new Set();
        const did_move = new Set();
        function insert(block) {
            transition_in(block, 1);
            block.m(node, next);
            lookup.set(block.key, block);
            next = block.first;
            n--;
        }
        while (o && n) {
            const new_block = new_blocks[n - 1];
            const old_block = old_blocks[o - 1];
            const new_key = new_block.key;
            const old_key = old_block.key;
            if (new_block === old_block) {
                // do nothing
                next = new_block.first;
                o--;
                n--;
            }
            else if (!new_lookup.has(old_key)) {
                // remove old block
                destroy(old_block, lookup);
                o--;
            }
            else if (!lookup.has(new_key) || will_move.has(new_key)) {
                insert(new_block);
            }
            else if (did_move.has(old_key)) {
                o--;
            }
            else if (deltas.get(new_key) > deltas.get(old_key)) {
                did_move.add(new_key);
                insert(new_block);
            }
            else {
                will_move.add(old_key);
                o--;
            }
        }
        while (o--) {
            const old_block = old_blocks[o];
            if (!new_lookup.has(old_block.key))
                destroy(old_block, lookup);
        }
        while (n)
            insert(new_blocks[n - 1]);
        run_all(updates);
        return new_blocks;
    }

    function get_spread_update(levels, updates) {
        const update = {};
        const to_null_out = {};
        const accounted_for = { $$scope: 1 };
        let i = levels.length;
        while (i--) {
            const o = levels[i];
            const n = updates[i];
            if (n) {
                for (const key in o) {
                    if (!(key in n))
                        to_null_out[key] = 1;
                }
                for (const key in n) {
                    if (!accounted_for[key]) {
                        update[key] = n[key];
                        accounted_for[key] = 1;
                    }
                }
                levels[i] = n;
            }
            else {
                for (const key in o) {
                    accounted_for[key] = 1;
                }
            }
        }
        for (const key in to_null_out) {
            if (!(key in update))
                update[key] = undefined;
        }
        return update;
    }
    function get_spread_object(spread_props) {
        return typeof spread_props === 'object' && spread_props !== null ? spread_props : {};
    }
    function create_component(block) {
        block && block.c();
    }
    function mount_component(component, target, anchor, customElement) {
        const { fragment, after_update } = component.$$;
        fragment && fragment.m(target, anchor);
        if (!customElement) {
            // onMount happens before the initial afterUpdate
            add_render_callback(() => {
                const new_on_destroy = component.$$.on_mount.map(run).filter(is_function);
                // if the component was destroyed immediately
                // it will update the `$$.on_destroy` reference to `null`.
                // the destructured on_destroy may still reference to the old array
                if (component.$$.on_destroy) {
                    component.$$.on_destroy.push(...new_on_destroy);
                }
                else {
                    // Edge case - component was destroyed immediately,
                    // most likely as a result of a binding initialising
                    run_all(new_on_destroy);
                }
                component.$$.on_mount = [];
            });
        }
        after_update.forEach(add_render_callback);
    }
    function destroy_component(component, detaching) {
        const $$ = component.$$;
        if ($$.fragment !== null) {
            flush_render_callbacks($$.after_update);
            run_all($$.on_destroy);
            $$.fragment && $$.fragment.d(detaching);
            // TODO null out other refs, including component.$$ (but need to
            // preserve final state?)
            $$.on_destroy = $$.fragment = null;
            $$.ctx = [];
        }
    }
    function make_dirty(component, i) {
        if (component.$$.dirty[0] === -1) {
            dirty_components.push(component);
            schedule_update();
            component.$$.dirty.fill(0);
        }
        component.$$.dirty[(i / 31) | 0] |= (1 << (i % 31));
    }
    function init(component, options, instance, create_fragment, not_equal, props, append_styles, dirty = [-1]) {
        const parent_component = current_component;
        set_current_component(component);
        const $$ = component.$$ = {
            fragment: null,
            ctx: [],
            // state
            props,
            update: noop$1,
            not_equal,
            bound: blank_object(),
            // lifecycle
            on_mount: [],
            on_destroy: [],
            on_disconnect: [],
            before_update: [],
            after_update: [],
            context: new Map(options.context || (parent_component ? parent_component.$$.context : [])),
            // everything else
            callbacks: blank_object(),
            dirty,
            skip_bound: false,
            root: options.target || parent_component.$$.root
        };
        append_styles && append_styles($$.root);
        let ready = false;
        $$.ctx = instance
            ? instance(component, options.props || {}, (i, ret, ...rest) => {
                const value = rest.length ? rest[0] : ret;
                if ($$.ctx && not_equal($$.ctx[i], $$.ctx[i] = value)) {
                    if (!$$.skip_bound && $$.bound[i])
                        $$.bound[i](value);
                    if (ready)
                        make_dirty(component, i);
                }
                return ret;
            })
            : [];
        $$.update();
        ready = true;
        run_all($$.before_update);
        // `false` as a special case of no DOM component
        $$.fragment = create_fragment ? create_fragment($$.ctx) : false;
        if (options.target) {
            if (options.hydrate) {
                const nodes = children(options.target);
                // eslint-disable-next-line @typescript-eslint/no-non-null-assertion
                $$.fragment && $$.fragment.l(nodes);
                nodes.forEach(detach);
            }
            else {
                // eslint-disable-next-line @typescript-eslint/no-non-null-assertion
                $$.fragment && $$.fragment.c();
            }
            if (options.intro)
                transition_in(component.$$.fragment);
            mount_component(component, options.target, options.anchor, options.customElement);
            flush();
        }
        set_current_component(parent_component);
    }
    /**
     * Base class for Svelte components. Used when dev=false.
     */
    class SvelteComponent {
        $destroy() {
            destroy_component(this, 1);
            this.$destroy = noop$1;
        }
        $on(type, callback) {
            if (!is_function(callback)) {
                return noop$1;
            }
            const callbacks = (this.$$.callbacks[type] || (this.$$.callbacks[type] = []));
            callbacks.push(callback);
            return () => {
                const index = callbacks.indexOf(callback);
                if (index !== -1)
                    callbacks.splice(index, 1);
            };
        }
        $set($$props) {
            if (this.$$set && !is_empty($$props)) {
                this.$$.skip_bound = true;
                this.$$set($$props);
                this.$$.skip_bound = false;
            }
        }
    }

    /**
     * Copyright 2016 Google Inc. All Rights Reserved.
     *
     * Licensed under the W3C SOFTWARE AND DOCUMENT NOTICE AND LICENSE.
     *
     *  https://www.w3.org/Consortium/Legal/2015/copyright-software-and-document
     *
     */
    (function() {

    // Exit early if we're not running in a browser.
    if (typeof window !== 'object') {
      return;
    }

    // Exit early if all IntersectionObserver and IntersectionObserverEntry
    // features are natively supported.
    if ('IntersectionObserver' in window &&
        'IntersectionObserverEntry' in window &&
        'intersectionRatio' in window.IntersectionObserverEntry.prototype) {

      // Minimal polyfill for Edge 15's lack of `isIntersecting`
      // See: https://github.com/w3c/IntersectionObserver/issues/211
      if (!('isIntersecting' in window.IntersectionObserverEntry.prototype)) {
        Object.defineProperty(window.IntersectionObserverEntry.prototype,
          'isIntersecting', {
          get: function () {
            return this.intersectionRatio > 0;
          }
        });
      }
      return;
    }

    /**
     * Returns the embedding frame element, if any.
     * @param {!Document} doc
     * @return {!Element}
     */
    function getFrameElement(doc) {
      try {
        return doc.defaultView && doc.defaultView.frameElement || null;
      } catch (e) {
        // Ignore the error.
        return null;
      }
    }

    /**
     * A local reference to the root document.
     */
    var document = (function(startDoc) {
      var doc = startDoc;
      var frame = getFrameElement(doc);
      while (frame) {
        doc = frame.ownerDocument;
        frame = getFrameElement(doc);
      }
      return doc;
    })(window.document);

    /**
     * An IntersectionObserver registry. This registry exists to hold a strong
     * reference to IntersectionObserver instances currently observing a target
     * element. Without this registry, instances without another reference may be
     * garbage collected.
     */
    var registry = [];

    /**
     * The signal updater for cross-origin intersection. When not null, it means
     * that the polyfill is configured to work in a cross-origin mode.
     * @type {function(DOMRect|ClientRect, DOMRect|ClientRect)}
     */
    var crossOriginUpdater = null;

    /**
     * The current cross-origin intersection. Only used in the cross-origin mode.
     * @type {DOMRect|ClientRect}
     */
    var crossOriginRect = null;


    /**
     * Creates the global IntersectionObserverEntry constructor.
     * https://w3c.github.io/IntersectionObserver/#intersection-observer-entry
     * @param {Object} entry A dictionary of instance properties.
     * @constructor
     */
    function IntersectionObserverEntry(entry) {
      this.time = entry.time;
      this.target = entry.target;
      this.rootBounds = ensureDOMRect(entry.rootBounds);
      this.boundingClientRect = ensureDOMRect(entry.boundingClientRect);
      this.intersectionRect = ensureDOMRect(entry.intersectionRect || getEmptyRect());
      this.isIntersecting = !!entry.intersectionRect;

      // Calculates the intersection ratio.
      var targetRect = this.boundingClientRect;
      var targetArea = targetRect.width * targetRect.height;
      var intersectionRect = this.intersectionRect;
      var intersectionArea = intersectionRect.width * intersectionRect.height;

      // Sets intersection ratio.
      if (targetArea) {
        // Round the intersection ratio to avoid floating point math issues:
        // https://github.com/w3c/IntersectionObserver/issues/324
        this.intersectionRatio = Number((intersectionArea / targetArea).toFixed(4));
      } else {
        // If area is zero and is intersecting, sets to 1, otherwise to 0
        this.intersectionRatio = this.isIntersecting ? 1 : 0;
      }
    }


    /**
     * Creates the global IntersectionObserver constructor.
     * https://w3c.github.io/IntersectionObserver/#intersection-observer-interface
     * @param {Function} callback The function to be invoked after intersection
     *     changes have queued. The function is not invoked if the queue has
     *     been emptied by calling the `takeRecords` method.
     * @param {Object=} opt_options Optional configuration options.
     * @constructor
     */
    function IntersectionObserver(callback, opt_options) {

      var options = opt_options || {};

      if (typeof callback != 'function') {
        throw new Error('callback must be a function');
      }

      if (
        options.root &&
        options.root.nodeType != 1 &&
        options.root.nodeType != 9
      ) {
        throw new Error('root must be a Document or Element');
      }

      // Binds and throttles `this._checkForIntersections`.
      this._checkForIntersections = throttle(
          this._checkForIntersections.bind(this), this.THROTTLE_TIMEOUT);

      // Private properties.
      this._callback = callback;
      this._observationTargets = [];
      this._queuedEntries = [];
      this._rootMarginValues = this._parseRootMargin(options.rootMargin);

      // Public properties.
      this.thresholds = this._initThresholds(options.threshold);
      this.root = options.root || null;
      this.rootMargin = this._rootMarginValues.map(function(margin) {
        return margin.value + margin.unit;
      }).join(' ');

      /** @private @const {!Array<!Document>} */
      this._monitoringDocuments = [];
      /** @private @const {!Array<function()>} */
      this._monitoringUnsubscribes = [];
    }


    /**
     * The minimum interval within which the document will be checked for
     * intersection changes.
     */
    IntersectionObserver.prototype.THROTTLE_TIMEOUT = 100;


    /**
     * The frequency in which the polyfill polls for intersection changes.
     * this can be updated on a per instance basis and must be set prior to
     * calling `observe` on the first target.
     */
    IntersectionObserver.prototype.POLL_INTERVAL = null;

    /**
     * Use a mutation observer on the root element
     * to detect intersection changes.
     */
    IntersectionObserver.prototype.USE_MUTATION_OBSERVER = true;


    /**
     * Sets up the polyfill in the cross-origin mode. The result is the
     * updater function that accepts two arguments: `boundingClientRect` and
     * `intersectionRect` - just as these fields would be available to the
     * parent via `IntersectionObserverEntry`. This function should be called
     * each time the iframe receives intersection information from the parent
     * window, e.g. via messaging.
     * @return {function(DOMRect|ClientRect, DOMRect|ClientRect)}
     */
    IntersectionObserver._setupCrossOriginUpdater = function() {
      if (!crossOriginUpdater) {
        /**
         * @param {DOMRect|ClientRect} boundingClientRect
         * @param {DOMRect|ClientRect} intersectionRect
         */
        crossOriginUpdater = function(boundingClientRect, intersectionRect) {
          if (!boundingClientRect || !intersectionRect) {
            crossOriginRect = getEmptyRect();
          } else {
            crossOriginRect = convertFromParentRect(boundingClientRect, intersectionRect);
          }
          registry.forEach(function(observer) {
            observer._checkForIntersections();
          });
        };
      }
      return crossOriginUpdater;
    };


    /**
     * Resets the cross-origin mode.
     */
    IntersectionObserver._resetCrossOriginUpdater = function() {
      crossOriginUpdater = null;
      crossOriginRect = null;
    };


    /**
     * Starts observing a target element for intersection changes based on
     * the thresholds values.
     * @param {Element} target The DOM element to observe.
     */
    IntersectionObserver.prototype.observe = function(target) {
      var isTargetAlreadyObserved = this._observationTargets.some(function(item) {
        return item.element == target;
      });

      if (isTargetAlreadyObserved) {
        return;
      }

      if (!(target && target.nodeType == 1)) {
        throw new Error('target must be an Element');
      }

      this._registerInstance();
      this._observationTargets.push({element: target, entry: null});
      this._monitorIntersections(target.ownerDocument);
      this._checkForIntersections();
    };


    /**
     * Stops observing a target element for intersection changes.
     * @param {Element} target The DOM element to observe.
     */
    IntersectionObserver.prototype.unobserve = function(target) {
      this._observationTargets =
          this._observationTargets.filter(function(item) {
            return item.element != target;
          });
      this._unmonitorIntersections(target.ownerDocument);
      if (this._observationTargets.length == 0) {
        this._unregisterInstance();
      }
    };


    /**
     * Stops observing all target elements for intersection changes.
     */
    IntersectionObserver.prototype.disconnect = function() {
      this._observationTargets = [];
      this._unmonitorAllIntersections();
      this._unregisterInstance();
    };


    /**
     * Returns any queue entries that have not yet been reported to the
     * callback and clears the queue. This can be used in conjunction with the
     * callback to obtain the absolute most up-to-date intersection information.
     * @return {Array} The currently queued entries.
     */
    IntersectionObserver.prototype.takeRecords = function() {
      var records = this._queuedEntries.slice();
      this._queuedEntries = [];
      return records;
    };


    /**
     * Accepts the threshold value from the user configuration object and
     * returns a sorted array of unique threshold values. If a value is not
     * between 0 and 1 and error is thrown.
     * @private
     * @param {Array|number=} opt_threshold An optional threshold value or
     *     a list of threshold values, defaulting to [0].
     * @return {Array} A sorted list of unique and valid threshold values.
     */
    IntersectionObserver.prototype._initThresholds = function(opt_threshold) {
      var threshold = opt_threshold || [0];
      if (!Array.isArray(threshold)) threshold = [threshold];

      return threshold.sort().filter(function(t, i, a) {
        if (typeof t != 'number' || isNaN(t) || t < 0 || t > 1) {
          throw new Error('threshold must be a number between 0 and 1 inclusively');
        }
        return t !== a[i - 1];
      });
    };


    /**
     * Accepts the rootMargin value from the user configuration object
     * and returns an array of the four margin values as an object containing
     * the value and unit properties. If any of the values are not properly
     * formatted or use a unit other than px or %, and error is thrown.
     * @private
     * @param {string=} opt_rootMargin An optional rootMargin value,
     *     defaulting to '0px'.
     * @return {Array<Object>} An array of margin objects with the keys
     *     value and unit.
     */
    IntersectionObserver.prototype._parseRootMargin = function(opt_rootMargin) {
      var marginString = opt_rootMargin || '0px';
      var margins = marginString.split(/\s+/).map(function(margin) {
        var parts = /^(-?\d*\.?\d+)(px|%)$/.exec(margin);
        if (!parts) {
          throw new Error('rootMargin must be specified in pixels or percent');
        }
        return {value: parseFloat(parts[1]), unit: parts[2]};
      });

      // Handles shorthand.
      margins[1] = margins[1] || margins[0];
      margins[2] = margins[2] || margins[0];
      margins[3] = margins[3] || margins[1];

      return margins;
    };


    /**
     * Starts polling for intersection changes if the polling is not already
     * happening, and if the page's visibility state is visible.
     * @param {!Document} doc
     * @private
     */
    IntersectionObserver.prototype._monitorIntersections = function(doc) {
      var win = doc.defaultView;
      if (!win) {
        // Already destroyed.
        return;
      }
      if (this._monitoringDocuments.indexOf(doc) != -1) {
        // Already monitoring.
        return;
      }

      // Private state for monitoring.
      var callback = this._checkForIntersections;
      var monitoringInterval = null;
      var domObserver = null;

      // If a poll interval is set, use polling instead of listening to
      // resize and scroll events or DOM mutations.
      if (this.POLL_INTERVAL) {
        monitoringInterval = win.setInterval(callback, this.POLL_INTERVAL);
      } else {
        addEvent(win, 'resize', callback, true);
        addEvent(doc, 'scroll', callback, true);
        if (this.USE_MUTATION_OBSERVER && 'MutationObserver' in win) {
          domObserver = new win.MutationObserver(callback);
          domObserver.observe(doc, {
            attributes: true,
            childList: true,
            characterData: true,
            subtree: true
          });
        }
      }

      this._monitoringDocuments.push(doc);
      this._monitoringUnsubscribes.push(function() {
        // Get the window object again. When a friendly iframe is destroyed, it
        // will be null.
        var win = doc.defaultView;

        if (win) {
          if (monitoringInterval) {
            win.clearInterval(monitoringInterval);
          }
          removeEvent(win, 'resize', callback, true);
        }

        removeEvent(doc, 'scroll', callback, true);
        if (domObserver) {
          domObserver.disconnect();
        }
      });

      // Also monitor the parent.
      var rootDoc =
        (this.root && (this.root.ownerDocument || this.root)) || document;
      if (doc != rootDoc) {
        var frame = getFrameElement(doc);
        if (frame) {
          this._monitorIntersections(frame.ownerDocument);
        }
      }
    };


    /**
     * Stops polling for intersection changes.
     * @param {!Document} doc
     * @private
     */
    IntersectionObserver.prototype._unmonitorIntersections = function(doc) {
      var index = this._monitoringDocuments.indexOf(doc);
      if (index == -1) {
        return;
      }

      var rootDoc =
        (this.root && (this.root.ownerDocument || this.root)) || document;

      // Check if any dependent targets are still remaining.
      var hasDependentTargets =
          this._observationTargets.some(function(item) {
            var itemDoc = item.element.ownerDocument;
            // Target is in this context.
            if (itemDoc == doc) {
              return true;
            }
            // Target is nested in this context.
            while (itemDoc && itemDoc != rootDoc) {
              var frame = getFrameElement(itemDoc);
              itemDoc = frame && frame.ownerDocument;
              if (itemDoc == doc) {
                return true;
              }
            }
            return false;
          });
      if (hasDependentTargets) {
        return;
      }

      // Unsubscribe.
      var unsubscribe = this._monitoringUnsubscribes[index];
      this._monitoringDocuments.splice(index, 1);
      this._monitoringUnsubscribes.splice(index, 1);
      unsubscribe();

      // Also unmonitor the parent.
      if (doc != rootDoc) {
        var frame = getFrameElement(doc);
        if (frame) {
          this._unmonitorIntersections(frame.ownerDocument);
        }
      }
    };


    /**
     * Stops polling for intersection changes.
     * @param {!Document} doc
     * @private
     */
    IntersectionObserver.prototype._unmonitorAllIntersections = function() {
      var unsubscribes = this._monitoringUnsubscribes.slice(0);
      this._monitoringDocuments.length = 0;
      this._monitoringUnsubscribes.length = 0;
      for (var i = 0; i < unsubscribes.length; i++) {
        unsubscribes[i]();
      }
    };


    /**
     * Scans each observation target for intersection changes and adds them
     * to the internal entries queue. If new entries are found, it
     * schedules the callback to be invoked.
     * @private
     */
    IntersectionObserver.prototype._checkForIntersections = function() {
      if (!this.root && crossOriginUpdater && !crossOriginRect) {
        // Cross origin monitoring, but no initial data available yet.
        return;
      }

      var rootIsInDom = this._rootIsInDom();
      var rootRect = rootIsInDom ? this._getRootRect() : getEmptyRect();

      this._observationTargets.forEach(function(item) {
        var target = item.element;
        var targetRect = getBoundingClientRect(target);
        var rootContainsTarget = this._rootContainsTarget(target);
        var oldEntry = item.entry;
        var intersectionRect = rootIsInDom && rootContainsTarget &&
            this._computeTargetAndRootIntersection(target, targetRect, rootRect);

        var rootBounds = null;
        if (!this._rootContainsTarget(target)) {
          rootBounds = getEmptyRect();
        } else if (!crossOriginUpdater || this.root) {
          rootBounds = rootRect;
        }

        var newEntry = item.entry = new IntersectionObserverEntry({
          time: now(),
          target: target,
          boundingClientRect: targetRect,
          rootBounds: rootBounds,
          intersectionRect: intersectionRect
        });

        if (!oldEntry) {
          this._queuedEntries.push(newEntry);
        } else if (rootIsInDom && rootContainsTarget) {
          // If the new entry intersection ratio has crossed any of the
          // thresholds, add a new entry.
          if (this._hasCrossedThreshold(oldEntry, newEntry)) {
            this._queuedEntries.push(newEntry);
          }
        } else {
          // If the root is not in the DOM or target is not contained within
          // root but the previous entry for this target had an intersection,
          // add a new record indicating removal.
          if (oldEntry && oldEntry.isIntersecting) {
            this._queuedEntries.push(newEntry);
          }
        }
      }, this);

      if (this._queuedEntries.length) {
        this._callback(this.takeRecords(), this);
      }
    };


    /**
     * Accepts a target and root rect computes the intersection between then
     * following the algorithm in the spec.
     * TODO(philipwalton): at this time clip-path is not considered.
     * https://w3c.github.io/IntersectionObserver/#calculate-intersection-rect-algo
     * @param {Element} target The target DOM element
     * @param {Object} targetRect The bounding rect of the target.
     * @param {Object} rootRect The bounding rect of the root after being
     *     expanded by the rootMargin value.
     * @return {?Object} The final intersection rect object or undefined if no
     *     intersection is found.
     * @private
     */
    IntersectionObserver.prototype._computeTargetAndRootIntersection =
        function(target, targetRect, rootRect) {
      // If the element isn't displayed, an intersection can't happen.
      if (window.getComputedStyle(target).display == 'none') return;

      var intersectionRect = targetRect;
      var parent = getParentNode(target);
      var atRoot = false;

      while (!atRoot && parent) {
        var parentRect = null;
        var parentComputedStyle = parent.nodeType == 1 ?
            window.getComputedStyle(parent) : {};

        // If the parent isn't displayed, an intersection can't happen.
        if (parentComputedStyle.display == 'none') return null;

        if (parent == this.root || parent.nodeType == /* DOCUMENT */ 9) {
          atRoot = true;
          if (parent == this.root || parent == document) {
            if (crossOriginUpdater && !this.root) {
              if (!crossOriginRect ||
                  crossOriginRect.width == 0 && crossOriginRect.height == 0) {
                // A 0-size cross-origin intersection means no-intersection.
                parent = null;
                parentRect = null;
                intersectionRect = null;
              } else {
                parentRect = crossOriginRect;
              }
            } else {
              parentRect = rootRect;
            }
          } else {
            // Check if there's a frame that can be navigated to.
            var frame = getParentNode(parent);
            var frameRect = frame && getBoundingClientRect(frame);
            var frameIntersect =
                frame &&
                this._computeTargetAndRootIntersection(frame, frameRect, rootRect);
            if (frameRect && frameIntersect) {
              parent = frame;
              parentRect = convertFromParentRect(frameRect, frameIntersect);
            } else {
              parent = null;
              intersectionRect = null;
            }
          }
        } else {
          // If the element has a non-visible overflow, and it's not the <body>
          // or <html> element, update the intersection rect.
          // Note: <body> and <html> cannot be clipped to a rect that's not also
          // the document rect, so no need to compute a new intersection.
          var doc = parent.ownerDocument;
          if (parent != doc.body &&
              parent != doc.documentElement &&
              parentComputedStyle.overflow != 'visible') {
            parentRect = getBoundingClientRect(parent);
          }
        }

        // If either of the above conditionals set a new parentRect,
        // calculate new intersection data.
        if (parentRect) {
          intersectionRect = computeRectIntersection(parentRect, intersectionRect);
        }
        if (!intersectionRect) break;
        parent = parent && getParentNode(parent);
      }
      return intersectionRect;
    };


    /**
     * Returns the root rect after being expanded by the rootMargin value.
     * @return {ClientRect} The expanded root rect.
     * @private
     */
    IntersectionObserver.prototype._getRootRect = function() {
      var rootRect;
      if (this.root && !isDoc(this.root)) {
        rootRect = getBoundingClientRect(this.root);
      } else {
        // Use <html>/<body> instead of window since scroll bars affect size.
        var doc = isDoc(this.root) ? this.root : document;
        var html = doc.documentElement;
        var body = doc.body;
        rootRect = {
          top: 0,
          left: 0,
          right: html.clientWidth || body.clientWidth,
          width: html.clientWidth || body.clientWidth,
          bottom: html.clientHeight || body.clientHeight,
          height: html.clientHeight || body.clientHeight
        };
      }
      return this._expandRectByRootMargin(rootRect);
    };


    /**
     * Accepts a rect and expands it by the rootMargin value.
     * @param {DOMRect|ClientRect} rect The rect object to expand.
     * @return {ClientRect} The expanded rect.
     * @private
     */
    IntersectionObserver.prototype._expandRectByRootMargin = function(rect) {
      var margins = this._rootMarginValues.map(function(margin, i) {
        return margin.unit == 'px' ? margin.value :
            margin.value * (i % 2 ? rect.width : rect.height) / 100;
      });
      var newRect = {
        top: rect.top - margins[0],
        right: rect.right + margins[1],
        bottom: rect.bottom + margins[2],
        left: rect.left - margins[3]
      };
      newRect.width = newRect.right - newRect.left;
      newRect.height = newRect.bottom - newRect.top;

      return newRect;
    };


    /**
     * Accepts an old and new entry and returns true if at least one of the
     * threshold values has been crossed.
     * @param {?IntersectionObserverEntry} oldEntry The previous entry for a
     *    particular target element or null if no previous entry exists.
     * @param {IntersectionObserverEntry} newEntry The current entry for a
     *    particular target element.
     * @return {boolean} Returns true if a any threshold has been crossed.
     * @private
     */
    IntersectionObserver.prototype._hasCrossedThreshold =
        function(oldEntry, newEntry) {

      // To make comparing easier, an entry that has a ratio of 0
      // but does not actually intersect is given a value of -1
      var oldRatio = oldEntry && oldEntry.isIntersecting ?
          oldEntry.intersectionRatio || 0 : -1;
      var newRatio = newEntry.isIntersecting ?
          newEntry.intersectionRatio || 0 : -1;

      // Ignore unchanged ratios
      if (oldRatio === newRatio) return;

      for (var i = 0; i < this.thresholds.length; i++) {
        var threshold = this.thresholds[i];

        // Return true if an entry matches a threshold or if the new ratio
        // and the old ratio are on the opposite sides of a threshold.
        if (threshold == oldRatio || threshold == newRatio ||
            threshold < oldRatio !== threshold < newRatio) {
          return true;
        }
      }
    };


    /**
     * Returns whether or not the root element is an element and is in the DOM.
     * @return {boolean} True if the root element is an element and is in the DOM.
     * @private
     */
    IntersectionObserver.prototype._rootIsInDom = function() {
      return !this.root || containsDeep(document, this.root);
    };


    /**
     * Returns whether or not the target element is a child of root.
     * @param {Element} target The target element to check.
     * @return {boolean} True if the target element is a child of root.
     * @private
     */
    IntersectionObserver.prototype._rootContainsTarget = function(target) {
      var rootDoc =
        (this.root && (this.root.ownerDocument || this.root)) || document;
      return (
        containsDeep(rootDoc, target) &&
        (!this.root || rootDoc == target.ownerDocument)
      );
    };


    /**
     * Adds the instance to the global IntersectionObserver registry if it isn't
     * already present.
     * @private
     */
    IntersectionObserver.prototype._registerInstance = function() {
      if (registry.indexOf(this) < 0) {
        registry.push(this);
      }
    };


    /**
     * Removes the instance from the global IntersectionObserver registry.
     * @private
     */
    IntersectionObserver.prototype._unregisterInstance = function() {
      var index = registry.indexOf(this);
      if (index != -1) registry.splice(index, 1);
    };


    /**
     * Returns the result of the performance.now() method or null in browsers
     * that don't support the API.
     * @return {number} The elapsed time since the page was requested.
     */
    function now() {
      return window.performance && performance.now && performance.now();
    }


    /**
     * Throttles a function and delays its execution, so it's only called at most
     * once within a given time period.
     * @param {Function} fn The function to throttle.
     * @param {number} timeout The amount of time that must pass before the
     *     function can be called again.
     * @return {Function} The throttled function.
     */
    function throttle(fn, timeout) {
      var timer = null;
      return function () {
        if (!timer) {
          timer = setTimeout(function() {
            fn();
            timer = null;
          }, timeout);
        }
      };
    }


    /**
     * Adds an event handler to a DOM node ensuring cross-browser compatibility.
     * @param {Node} node The DOM node to add the event handler to.
     * @param {string} event The event name.
     * @param {Function} fn The event handler to add.
     * @param {boolean} opt_useCapture Optionally adds the even to the capture
     *     phase. Note: this only works in modern browsers.
     */
    function addEvent(node, event, fn, opt_useCapture) {
      if (typeof node.addEventListener == 'function') {
        node.addEventListener(event, fn, opt_useCapture || false);
      }
      else if (typeof node.attachEvent == 'function') {
        node.attachEvent('on' + event, fn);
      }
    }


    /**
     * Removes a previously added event handler from a DOM node.
     * @param {Node} node The DOM node to remove the event handler from.
     * @param {string} event The event name.
     * @param {Function} fn The event handler to remove.
     * @param {boolean} opt_useCapture If the event handler was added with this
     *     flag set to true, it should be set to true here in order to remove it.
     */
    function removeEvent(node, event, fn, opt_useCapture) {
      if (typeof node.removeEventListener == 'function') {
        node.removeEventListener(event, fn, opt_useCapture || false);
      }
      else if (typeof node.detachEvent == 'function') {
        node.detachEvent('on' + event, fn);
      }
    }


    /**
     * Returns the intersection between two rect objects.
     * @param {Object} rect1 The first rect.
     * @param {Object} rect2 The second rect.
     * @return {?Object|?ClientRect} The intersection rect or undefined if no
     *     intersection is found.
     */
    function computeRectIntersection(rect1, rect2) {
      var top = Math.max(rect1.top, rect2.top);
      var bottom = Math.min(rect1.bottom, rect2.bottom);
      var left = Math.max(rect1.left, rect2.left);
      var right = Math.min(rect1.right, rect2.right);
      var width = right - left;
      var height = bottom - top;

      return (width >= 0 && height >= 0) && {
        top: top,
        bottom: bottom,
        left: left,
        right: right,
        width: width,
        height: height
      } || null;
    }


    /**
     * Shims the native getBoundingClientRect for compatibility with older IE.
     * @param {Element} el The element whose bounding rect to get.
     * @return {DOMRect|ClientRect} The (possibly shimmed) rect of the element.
     */
    function getBoundingClientRect(el) {
      var rect;

      try {
        rect = el.getBoundingClientRect();
      } catch (err) {
        // Ignore Windows 7 IE11 "Unspecified error"
        // https://github.com/w3c/IntersectionObserver/pull/205
      }

      if (!rect) return getEmptyRect();

      // Older IE
      if (!(rect.width && rect.height)) {
        rect = {
          top: rect.top,
          right: rect.right,
          bottom: rect.bottom,
          left: rect.left,
          width: rect.right - rect.left,
          height: rect.bottom - rect.top
        };
      }
      return rect;
    }


    /**
     * Returns an empty rect object. An empty rect is returned when an element
     * is not in the DOM.
     * @return {ClientRect} The empty rect.
     */
    function getEmptyRect() {
      return {
        top: 0,
        bottom: 0,
        left: 0,
        right: 0,
        width: 0,
        height: 0
      };
    }


    /**
     * Ensure that the result has all of the necessary fields of the DOMRect.
     * Specifically this ensures that `x` and `y` fields are set.
     *
     * @param {?DOMRect|?ClientRect} rect
     * @return {?DOMRect}
     */
    function ensureDOMRect(rect) {
      // A `DOMRect` object has `x` and `y` fields.
      if (!rect || 'x' in rect) {
        return rect;
      }
      // A IE's `ClientRect` type does not have `x` and `y`. The same is the case
      // for internally calculated Rect objects. For the purposes of
      // `IntersectionObserver`, it's sufficient to simply mirror `left` and `top`
      // for these fields.
      return {
        top: rect.top,
        y: rect.top,
        bottom: rect.bottom,
        left: rect.left,
        x: rect.left,
        right: rect.right,
        width: rect.width,
        height: rect.height
      };
    }


    /**
     * Inverts the intersection and bounding rect from the parent (frame) BCR to
     * the local BCR space.
     * @param {DOMRect|ClientRect} parentBoundingRect The parent's bound client rect.
     * @param {DOMRect|ClientRect} parentIntersectionRect The parent's own intersection rect.
     * @return {ClientRect} The local root bounding rect for the parent's children.
     */
    function convertFromParentRect(parentBoundingRect, parentIntersectionRect) {
      var top = parentIntersectionRect.top - parentBoundingRect.top;
      var left = parentIntersectionRect.left - parentBoundingRect.left;
      return {
        top: top,
        left: left,
        height: parentIntersectionRect.height,
        width: parentIntersectionRect.width,
        bottom: top + parentIntersectionRect.height,
        right: left + parentIntersectionRect.width
      };
    }


    /**
     * Checks to see if a parent element contains a child element (including inside
     * shadow DOM).
     * @param {Node} parent The parent element.
     * @param {Node} child The child element.
     * @return {boolean} True if the parent node contains the child node.
     */
    function containsDeep(parent, child) {
      var node = child;
      while (node) {
        if (node == parent) return true;

        node = getParentNode(node);
      }
      return false;
    }


    /**
     * Gets the parent node of an element or its host element if the parent node
     * is a shadow root.
     * @param {Node} node The node whose parent to get.
     * @return {Node|null} The parent node or null if no parent exists.
     */
    function getParentNode(node) {
      var parent = node.parentNode;

      if (node.nodeType == /* DOCUMENT */ 9 && node != document) {
        // If this node is a document node, look for the embedding frame.
        return getFrameElement(node);
      }

      // If the parent has element that is assigned through shadow root slot
      if (parent && parent.assignedSlot) {
        parent = parent.assignedSlot.parentNode;
      }

      if (parent && parent.nodeType == 11 && parent.host) {
        // If the parent is a shadow root, return the host element.
        return parent.host;
      }

      return parent;
    }

    /**
     * Returns true if `node` is a Document.
     * @param {!Node} node
     * @returns {boolean}
     */
    function isDoc(node) {
      return node && node.nodeType === 9;
    }


    // Exposes the constructors globally.
    window.IntersectionObserver = IntersectionObserver;
    window.IntersectionObserverEntry = IntersectionObserverEntry;

    }());

    const subscriber_queue = [];
    /**
     * Creates a `Readable` store that allows reading by subscription.
     * @param value initial value
     * @param {StartStopNotifier}start start and stop notifications for subscriptions
     */
    function readable(value, start) {
        return {
            subscribe: writable(value, start).subscribe
        };
    }
    /**
     * Create a `Writable` store that allows both updating and reading by subscription.
     * @param {*=}value initial value
     * @param {StartStopNotifier=}start start and stop notifications for subscriptions
     */
    function writable(value, start = noop$1) {
        let stop;
        const subscribers = new Set();
        function set(new_value) {
            if (safe_not_equal(value, new_value)) {
                value = new_value;
                if (stop) { // store is ready
                    const run_queue = !subscriber_queue.length;
                    for (const subscriber of subscribers) {
                        subscriber[1]();
                        subscriber_queue.push(subscriber, value);
                    }
                    if (run_queue) {
                        for (let i = 0; i < subscriber_queue.length; i += 2) {
                            subscriber_queue[i][0](subscriber_queue[i + 1]);
                        }
                        subscriber_queue.length = 0;
                    }
                }
            }
        }
        function update(fn) {
            set(fn(value));
        }
        function subscribe(run, invalidate = noop$1) {
            const subscriber = [run, invalidate];
            subscribers.add(subscriber);
            if (subscribers.size === 1) {
                stop = start(set) || noop$1;
            }
            run(value);
            return () => {
                subscribers.delete(subscriber);
                if (subscribers.size === 0 && stop) {
                    stop();
                    stop = null;
                }
            };
        }
        return { set, update, subscribe };
    }
    function derived(stores, fn, initial_value) {
        const single = !Array.isArray(stores);
        const stores_array = single
            ? [stores]
            : stores;
        const auto = fn.length < 2;
        return readable(initial_value, (set) => {
            let started = false;
            const values = [];
            let pending = 0;
            let cleanup = noop$1;
            const sync = () => {
                if (pending) {
                    return;
                }
                cleanup();
                const result = fn(single ? values[0] : values, set);
                if (auto) {
                    set(result);
                }
                else {
                    cleanup = is_function(result) ? result : noop$1;
                }
            };
            const unsubscribers = stores_array.map((store, i) => subscribe(store, (value) => {
                values[i] = value;
                pending &= ~(1 << i);
                if (started) {
                    sync();
                }
            }, () => {
                pending |= (1 << i);
            }));
            started = true;
            sync();
            return function stop() {
                run_all(unsubscribers);
                cleanup();
                // We need to set this to false because callbacks can still happen despite having unsubscribed:
                // Callbacks might already be placed in the queue which doesn't know it should no longer
                // invoke this derived store.
                started = false;
            };
        });
    }

    const LOCATION = {};
    const ROUTER = {};

    /**
     * Adapted from https://github.com/reach/router/blob/b60e6dd781d5d3a4bdaaf4de665649c0f6a7e78d/src/lib/history.js
     *
     * https://github.com/reach/router/blob/master/LICENSE
     * */

    function getLocation(source) {
      return {
        ...source.location,
        state: source.history.state,
        key: (source.history.state && source.history.state.key) || "initial"
      };
    }

    function createHistory(source, options) {
      const listeners = [];
      let location = getLocation(source);

      return {
        get location() {
          return location;
        },

        listen(listener) {
          listeners.push(listener);

          const popstateListener = () => {
            location = getLocation(source);
            listener({ location, action: "POP" });
          };

          source.addEventListener("popstate", popstateListener);

          return () => {
            source.removeEventListener("popstate", popstateListener);

            const index = listeners.indexOf(listener);
            listeners.splice(index, 1);
          };
        },

        navigate(to, { state, replace = false } = {}) {
          state = { ...state, key: Date.now() + "" };
          // try...catch iOS Safari limits to 100 pushState calls
          try {
            if (replace) {
              source.history.replaceState(state, null, to);
            } else {
              source.history.pushState(state, null, to);
            }
          } catch (e) {
            source.location[replace ? "replace" : "assign"](to);
          }

          location = getLocation(source);
          listeners.forEach(listener => listener({ location, action: "PUSH" }));
        }
      };
    }

    // Stores history entries in memory for testing or other platforms like Native
    function createMemorySource(initialPathname = "/") {
      let index = 0;
      const stack = [{ pathname: initialPathname, search: "" }];
      const states = [];

      return {
        get location() {
          return stack[index];
        },
        addEventListener(name, fn) {},
        removeEventListener(name, fn) {},
        history: {
          get entries() {
            return stack;
          },
          get index() {
            return index;
          },
          get state() {
            return states[index];
          },
          pushState(state, _, uri) {
            const [pathname, search = ""] = uri.split("?");
            index++;
            stack.push({ pathname, search });
            states.push(state);
          },
          replaceState(state, _, uri) {
            const [pathname, search = ""] = uri.split("?");
            stack[index] = { pathname, search };
            states[index] = state;
          }
        }
      };
    }

    // Global history uses window.history as the source if available,
    // otherwise a memory history
    const canUseDOM = Boolean(
      typeof window !== "undefined" &&
        window.document &&
        window.document.createElement
    );
    const globalHistory = createHistory(canUseDOM ? window : createMemorySource());
    const { navigate } = globalHistory;

    /**
     * Adapted from https://github.com/reach/router/blob/b60e6dd781d5d3a4bdaaf4de665649c0f6a7e78d/src/lib/utils.js
     *
     * https://github.com/reach/router/blob/master/LICENSE
     * */

    const paramRe = /^:(.+)/;

    const SEGMENT_POINTS = 4;
    const STATIC_POINTS = 3;
    const DYNAMIC_POINTS = 2;
    const SPLAT_PENALTY = 1;
    const ROOT_POINTS = 1;

    /**
     * Check if `segment` is a root segment
     * @param {string} segment
     * @return {boolean}
     */
    function isRootSegment(segment) {
      return segment === "";
    }

    /**
     * Check if `segment` is a dynamic segment
     * @param {string} segment
     * @return {boolean}
     */
    function isDynamic(segment) {
      return paramRe.test(segment);
    }

    /**
     * Check if `segment` is a splat
     * @param {string} segment
     * @return {boolean}
     */
    function isSplat(segment) {
      return segment[0] === "*";
    }

    /**
     * Split up the URI into segments delimited by `/`
     * @param {string} uri
     * @return {string[]}
     */
    function segmentize(uri) {
      return (
        uri
          // Strip starting/ending `/`
          .replace(/(^\/+|\/+$)/g, "")
          .split("/")
      );
    }

    /**
     * Strip `str` of potential start and end `/`
     * @param {string} str
     * @return {string}
     */
    function stripSlashes(str) {
      return str.replace(/(^\/+|\/+$)/g, "");
    }

    /**
     * Score a route depending on how its individual segments look
     * @param {object} route
     * @param {number} index
     * @return {object}
     */
    function rankRoute(route, index) {
      const score = route.default
        ? 0
        : segmentize(route.path).reduce((score, segment) => {
            score += SEGMENT_POINTS;

            if (isRootSegment(segment)) {
              score += ROOT_POINTS;
            } else if (isDynamic(segment)) {
              score += DYNAMIC_POINTS;
            } else if (isSplat(segment)) {
              score -= SEGMENT_POINTS + SPLAT_PENALTY;
            } else {
              score += STATIC_POINTS;
            }

            return score;
          }, 0);

      return { route, score, index };
    }

    /**
     * Give a score to all routes and sort them on that
     * @param {object[]} routes
     * @return {object[]}
     */
    function rankRoutes(routes) {
      return (
        routes
          .map(rankRoute)
          // If two routes have the exact same score, we go by index instead
          .sort((a, b) =>
            a.score < b.score ? 1 : a.score > b.score ? -1 : a.index - b.index
          )
      );
    }

    /**
     * Ranks and picks the best route to match. Each segment gets the highest
     * amount of points, then the type of segment gets an additional amount of
     * points where
     *
     *  static > dynamic > splat > root
     *
     * This way we don't have to worry about the order of our routes, let the
     * computers do it.
     *
     * A route looks like this
     *
     *  { path, default, value }
     *
     * And a returned match looks like:
     *
     *  { route, params, uri }
     *
     * @param {object[]} routes
     * @param {string} uri
     * @return {?object}
     */
    function pick(routes, uri) {
      let match;
      let default_;

      const [uriPathname] = uri.split("?");
      const uriSegments = segmentize(uriPathname);
      const isRootUri = uriSegments[0] === "";
      const ranked = rankRoutes(routes);

      for (let i = 0, l = ranked.length; i < l; i++) {
        const route = ranked[i].route;
        let missed = false;

        if (route.default) {
          default_ = {
            route,
            params: {},
            uri
          };
          continue;
        }

        const routeSegments = segmentize(route.path);
        const params = {};
        const max = Math.max(uriSegments.length, routeSegments.length);
        let index = 0;

        for (; index < max; index++) {
          const routeSegment = routeSegments[index];
          const uriSegment = uriSegments[index];

          if (routeSegment !== undefined && isSplat(routeSegment)) {
            // Hit a splat, just grab the rest, and return a match
            // uri:   /files/documents/work
            // route: /files/* or /files/*splatname
            const splatName = routeSegment === "*" ? "*" : routeSegment.slice(1);

            params[splatName] = uriSegments
              .slice(index)
              .map(decodeURIComponent)
              .join("/");
            break;
          }

          if (uriSegment === undefined) {
            // URI is shorter than the route, no match
            // uri:   /users
            // route: /users/:userId
            missed = true;
            break;
          }

          let dynamicMatch = paramRe.exec(routeSegment);

          if (dynamicMatch && !isRootUri) {
            const value = decodeURIComponent(uriSegment);
            params[dynamicMatch[1]] = value;
          } else if (routeSegment !== uriSegment) {
            // Current segments don't match, not dynamic, not splat, so no match
            // uri:   /users/123/settings
            // route: /users/:id/profile
            missed = true;
            break;
          }
        }

        if (!missed) {
          match = {
            route,
            params,
            uri: "/" + uriSegments.slice(0, index).join("/")
          };
          break;
        }
      }

      return match || default_ || null;
    }

    /**
     * Check if the `path` matches the `uri`.
     * @param {string} path
     * @param {string} uri
     * @return {?object}
     */
    function match(route, uri) {
      return pick([route], uri);
    }

    /**
     * Combines the `basepath` and the `path` into one path.
     * @param {string} basepath
     * @param {string} path
     */
    function combinePaths(basepath, path) {
      return `${stripSlashes(
    path === "/" ? basepath : `${stripSlashes(basepath)}/${stripSlashes(path)}`
  )}/`;
    }

    /**
     * Decides whether a given `event` should result in a navigation or not.
     * @param {object} event
     */
    function shouldNavigate(event) {
      return (
        !event.defaultPrevented &&
        event.button === 0 &&
        !(event.metaKey || event.altKey || event.ctrlKey || event.shiftKey)
      );
    }

    function hostMatches(anchor) {
      const host = location.host;
      return (
        anchor.host == host ||
        // svelte seems to kill anchor.host value in ie11, so fall back to checking href
        anchor.href.indexOf(`https://${host}`) === 0 ||
        anchor.href.indexOf(`http://${host}`) === 0
      )
    }

    /* node_modules\svelte-routing\src\Router.svelte generated by Svelte v3.58.0 */

    function create_fragment$j(ctx) {
    	let current;
    	const default_slot_template = /*#slots*/ ctx[9].default;
    	const default_slot = create_slot(default_slot_template, ctx, /*$$scope*/ ctx[8], null);

    	return {
    		c() {
    			if (default_slot) default_slot.c();
    		},
    		m(target, anchor) {
    			if (default_slot) {
    				default_slot.m(target, anchor);
    			}

    			current = true;
    		},
    		p(ctx, [dirty]) {
    			if (default_slot) {
    				if (default_slot.p && (!current || dirty & /*$$scope*/ 256)) {
    					update_slot_base(
    						default_slot,
    						default_slot_template,
    						ctx,
    						/*$$scope*/ ctx[8],
    						!current
    						? get_all_dirty_from_scope(/*$$scope*/ ctx[8])
    						: get_slot_changes(default_slot_template, /*$$scope*/ ctx[8], dirty, null),
    						null
    					);
    				}
    			}
    		},
    		i(local) {
    			if (current) return;
    			transition_in(default_slot, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(default_slot, local);
    			current = false;
    		},
    		d(detaching) {
    			if (default_slot) default_slot.d(detaching);
    		}
    	};
    }

    function instance$i($$self, $$props, $$invalidate) {
    	let $location;
    	let $routes;
    	let $base;
    	let { $$slots: slots = {}, $$scope } = $$props;
    	let { basepath = "/" } = $$props;
    	let { url = null } = $$props;
    	const locationContext = getContext(LOCATION);
    	const routerContext = getContext(ROUTER);
    	const routes = writable([]);
    	component_subscribe($$self, routes, value => $$invalidate(6, $routes = value));
    	const activeRoute = writable(null);
    	let hasActiveRoute = false; // Used in SSR to synchronously set that a Route is active.

    	// If locationContext is not set, this is the topmost Router in the tree.
    	// If the `url` prop is given we force the location to it.
    	const location = locationContext || writable(url ? { pathname: url } : globalHistory.location);

    	component_subscribe($$self, location, value => $$invalidate(5, $location = value));

    	// If routerContext is set, the routerBase of the parent Router
    	// will be the base for this Router's descendants.
    	// If routerContext is not set, the path and resolved uri will both
    	// have the value of the basepath prop.
    	const base = routerContext
    	? routerContext.routerBase
    	: writable({ path: basepath, uri: basepath });

    	component_subscribe($$self, base, value => $$invalidate(7, $base = value));

    	const routerBase = derived([base, activeRoute], ([base, activeRoute]) => {
    		// If there is no activeRoute, the routerBase will be identical to the base.
    		if (activeRoute === null) {
    			return base;
    		}

    		const { path: basepath } = base;
    		const { route, uri } = activeRoute;

    		// Remove the potential /* or /*splatname from
    		// the end of the child Routes relative paths.
    		const path = route.default
    		? basepath
    		: route.path.replace(/\*.*$/, "");

    		return { path, uri };
    	});

    	function registerRoute(route) {
    		const { path: basepath } = $base;
    		let { path } = route;

    		// We store the original path in the _path property so we can reuse
    		// it when the basepath changes. The only thing that matters is that
    		// the route reference is intact, so mutation is fine.
    		route._path = path;

    		route.path = combinePaths(basepath, path);

    		if (typeof window === "undefined") {
    			// In SSR we should set the activeRoute immediately if it is a match.
    			// If there are more Routes being registered after a match is found,
    			// we just skip them.
    			if (hasActiveRoute) {
    				return;
    			}

    			const matchingRoute = match(route, $location.pathname);

    			if (matchingRoute) {
    				activeRoute.set(matchingRoute);
    				hasActiveRoute = true;
    			}
    		} else {
    			routes.update(rs => {
    				rs.push(route);
    				return rs;
    			});
    		}
    	}

    	function unregisterRoute(route) {
    		routes.update(rs => {
    			const index = rs.indexOf(route);
    			rs.splice(index, 1);
    			return rs;
    		});
    	}

    	if (!locationContext) {
    		// The topmost Router in the tree is responsible for updating
    		// the location store and supplying it through context.
    		onMount(() => {
    			const unlisten = globalHistory.listen(history => {
    				location.set(history.location);
    			});

    			return unlisten;
    		});

    		setContext(LOCATION, location);
    	}

    	setContext(ROUTER, {
    		activeRoute,
    		base,
    		routerBase,
    		registerRoute,
    		unregisterRoute
    	});

    	$$self.$$set = $$props => {
    		if ('basepath' in $$props) $$invalidate(3, basepath = $$props.basepath);
    		if ('url' in $$props) $$invalidate(4, url = $$props.url);
    		if ('$$scope' in $$props) $$invalidate(8, $$scope = $$props.$$scope);
    	};

    	$$self.$$.update = () => {
    		if ($$self.$$.dirty & /*$base*/ 128) {
    			// This reactive statement will update all the Routes' path when
    			// the basepath changes.
    			{
    				const { path: basepath } = $base;

    				routes.update(rs => {
    					rs.forEach(r => r.path = combinePaths(basepath, r._path));
    					return rs;
    				});
    			}
    		}

    		if ($$self.$$.dirty & /*$routes, $location*/ 96) {
    			// This reactive statement will be run when the Router is created
    			// when there are no Routes and then again the following tick, so it
    			// will not find an active Route in SSR and in the browser it will only
    			// pick an active Route after all Routes have been registered.
    			{
    				const bestMatch = pick($routes, $location.pathname);
    				activeRoute.set(bestMatch);
    			}
    		}
    	};

    	return [
    		routes,
    		location,
    		base,
    		basepath,
    		url,
    		$location,
    		$routes,
    		$base,
    		$$scope,
    		slots
    	];
    }

    class Router extends SvelteComponent {
    	constructor(options) {
    		super();
    		init(this, options, instance$i, create_fragment$j, safe_not_equal, { basepath: 3, url: 4 });
    	}
    }

    /* node_modules\svelte-routing\src\Route.svelte generated by Svelte v3.58.0 */

    const get_default_slot_changes$1 = dirty => ({
    	params: dirty & /*routeParams*/ 4,
    	location: dirty & /*$location*/ 16
    });

    const get_default_slot_context$1 = ctx => ({
    	params: /*routeParams*/ ctx[2],
    	location: /*$location*/ ctx[4]
    });

    // (40:0) {#if $activeRoute !== null && $activeRoute.route === route}
    function create_if_block$e(ctx) {
    	let current_block_type_index;
    	let if_block;
    	let if_block_anchor;
    	let current;
    	const if_block_creators = [create_if_block_1$c, create_else_block$6];
    	const if_blocks = [];

    	function select_block_type(ctx, dirty) {
    		if (/*component*/ ctx[0] !== null) return 0;
    		return 1;
    	}

    	current_block_type_index = select_block_type(ctx);
    	if_block = if_blocks[current_block_type_index] = if_block_creators[current_block_type_index](ctx);

    	return {
    		c() {
    			if_block.c();
    			if_block_anchor = empty();
    		},
    		m(target, anchor) {
    			if_blocks[current_block_type_index].m(target, anchor);
    			insert(target, if_block_anchor, anchor);
    			current = true;
    		},
    		p(ctx, dirty) {
    			let previous_block_index = current_block_type_index;
    			current_block_type_index = select_block_type(ctx);

    			if (current_block_type_index === previous_block_index) {
    				if_blocks[current_block_type_index].p(ctx, dirty);
    			} else {
    				group_outros();

    				transition_out(if_blocks[previous_block_index], 1, 1, () => {
    					if_blocks[previous_block_index] = null;
    				});

    				check_outros();
    				if_block = if_blocks[current_block_type_index];

    				if (!if_block) {
    					if_block = if_blocks[current_block_type_index] = if_block_creators[current_block_type_index](ctx);
    					if_block.c();
    				} else {
    					if_block.p(ctx, dirty);
    				}

    				transition_in(if_block, 1);
    				if_block.m(if_block_anchor.parentNode, if_block_anchor);
    			}
    		},
    		i(local) {
    			if (current) return;
    			transition_in(if_block);
    			current = true;
    		},
    		o(local) {
    			transition_out(if_block);
    			current = false;
    		},
    		d(detaching) {
    			if_blocks[current_block_type_index].d(detaching);
    			if (detaching) detach(if_block_anchor);
    		}
    	};
    }

    // (43:2) {:else}
    function create_else_block$6(ctx) {
    	let current;
    	const default_slot_template = /*#slots*/ ctx[10].default;
    	const default_slot = create_slot(default_slot_template, ctx, /*$$scope*/ ctx[9], get_default_slot_context$1);

    	return {
    		c() {
    			if (default_slot) default_slot.c();
    		},
    		m(target, anchor) {
    			if (default_slot) {
    				default_slot.m(target, anchor);
    			}

    			current = true;
    		},
    		p(ctx, dirty) {
    			if (default_slot) {
    				if (default_slot.p && (!current || dirty & /*$$scope, routeParams, $location*/ 532)) {
    					update_slot_base(
    						default_slot,
    						default_slot_template,
    						ctx,
    						/*$$scope*/ ctx[9],
    						!current
    						? get_all_dirty_from_scope(/*$$scope*/ ctx[9])
    						: get_slot_changes(default_slot_template, /*$$scope*/ ctx[9], dirty, get_default_slot_changes$1),
    						get_default_slot_context$1
    					);
    				}
    			}
    		},
    		i(local) {
    			if (current) return;
    			transition_in(default_slot, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(default_slot, local);
    			current = false;
    		},
    		d(detaching) {
    			if (default_slot) default_slot.d(detaching);
    		}
    	};
    }

    // (41:2) {#if component !== null}
    function create_if_block_1$c(ctx) {
    	let switch_instance;
    	let switch_instance_anchor;
    	let current;

    	const switch_instance_spread_levels = [
    		{ location: /*$location*/ ctx[4] },
    		/*routeParams*/ ctx[2],
    		/*routeProps*/ ctx[3]
    	];

    	var switch_value = /*component*/ ctx[0];

    	function switch_props(ctx) {
    		let switch_instance_props = {};

    		for (let i = 0; i < switch_instance_spread_levels.length; i += 1) {
    			switch_instance_props = assign(switch_instance_props, switch_instance_spread_levels[i]);
    		}

    		return { props: switch_instance_props };
    	}

    	if (switch_value) {
    		switch_instance = construct_svelte_component(switch_value, switch_props());
    	}

    	return {
    		c() {
    			if (switch_instance) create_component(switch_instance.$$.fragment);
    			switch_instance_anchor = empty();
    		},
    		m(target, anchor) {
    			if (switch_instance) mount_component(switch_instance, target, anchor);
    			insert(target, switch_instance_anchor, anchor);
    			current = true;
    		},
    		p(ctx, dirty) {
    			const switch_instance_changes = (dirty & /*$location, routeParams, routeProps*/ 28)
    			? get_spread_update(switch_instance_spread_levels, [
    					dirty & /*$location*/ 16 && { location: /*$location*/ ctx[4] },
    					dirty & /*routeParams*/ 4 && get_spread_object(/*routeParams*/ ctx[2]),
    					dirty & /*routeProps*/ 8 && get_spread_object(/*routeProps*/ ctx[3])
    				])
    			: {};

    			if (dirty & /*component*/ 1 && switch_value !== (switch_value = /*component*/ ctx[0])) {
    				if (switch_instance) {
    					group_outros();
    					const old_component = switch_instance;

    					transition_out(old_component.$$.fragment, 1, 0, () => {
    						destroy_component(old_component, 1);
    					});

    					check_outros();
    				}

    				if (switch_value) {
    					switch_instance = construct_svelte_component(switch_value, switch_props());
    					create_component(switch_instance.$$.fragment);
    					transition_in(switch_instance.$$.fragment, 1);
    					mount_component(switch_instance, switch_instance_anchor.parentNode, switch_instance_anchor);
    				} else {
    					switch_instance = null;
    				}
    			} else if (switch_value) {
    				switch_instance.$set(switch_instance_changes);
    			}
    		},
    		i(local) {
    			if (current) return;
    			if (switch_instance) transition_in(switch_instance.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			if (switch_instance) transition_out(switch_instance.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			if (detaching) detach(switch_instance_anchor);
    			if (switch_instance) destroy_component(switch_instance, detaching);
    		}
    	};
    }

    function create_fragment$i(ctx) {
    	let if_block_anchor;
    	let current;
    	let if_block = /*$activeRoute*/ ctx[1] !== null && /*$activeRoute*/ ctx[1].route === /*route*/ ctx[7] && create_if_block$e(ctx);

    	return {
    		c() {
    			if (if_block) if_block.c();
    			if_block_anchor = empty();
    		},
    		m(target, anchor) {
    			if (if_block) if_block.m(target, anchor);
    			insert(target, if_block_anchor, anchor);
    			current = true;
    		},
    		p(ctx, [dirty]) {
    			if (/*$activeRoute*/ ctx[1] !== null && /*$activeRoute*/ ctx[1].route === /*route*/ ctx[7]) {
    				if (if_block) {
    					if_block.p(ctx, dirty);

    					if (dirty & /*$activeRoute*/ 2) {
    						transition_in(if_block, 1);
    					}
    				} else {
    					if_block = create_if_block$e(ctx);
    					if_block.c();
    					transition_in(if_block, 1);
    					if_block.m(if_block_anchor.parentNode, if_block_anchor);
    				}
    			} else if (if_block) {
    				group_outros();

    				transition_out(if_block, 1, 1, () => {
    					if_block = null;
    				});

    				check_outros();
    			}
    		},
    		i(local) {
    			if (current) return;
    			transition_in(if_block);
    			current = true;
    		},
    		o(local) {
    			transition_out(if_block);
    			current = false;
    		},
    		d(detaching) {
    			if (if_block) if_block.d(detaching);
    			if (detaching) detach(if_block_anchor);
    		}
    	};
    }

    function instance$h($$self, $$props, $$invalidate) {
    	let $activeRoute;
    	let $location;
    	let { $$slots: slots = {}, $$scope } = $$props;
    	let { path = "" } = $$props;
    	let { component = null } = $$props;
    	const { registerRoute, unregisterRoute, activeRoute } = getContext(ROUTER);
    	component_subscribe($$self, activeRoute, value => $$invalidate(1, $activeRoute = value));
    	const location = getContext(LOCATION);
    	component_subscribe($$self, location, value => $$invalidate(4, $location = value));

    	const route = {
    		path,
    		// If no path prop is given, this Route will act as the default Route
    		// that is rendered if no other Route in the Router is a match.
    		default: path === ""
    	};

    	let routeParams = {};
    	let routeProps = {};
    	registerRoute(route);

    	// There is no need to unregister Routes in SSR since it will all be
    	// thrown away anyway.
    	if (typeof window !== "undefined") {
    		onDestroy(() => {
    			unregisterRoute(route);
    		});
    	}

    	$$self.$$set = $$new_props => {
    		$$invalidate(13, $$props = assign(assign({}, $$props), exclude_internal_props($$new_props)));
    		if ('path' in $$new_props) $$invalidate(8, path = $$new_props.path);
    		if ('component' in $$new_props) $$invalidate(0, component = $$new_props.component);
    		if ('$$scope' in $$new_props) $$invalidate(9, $$scope = $$new_props.$$scope);
    	};

    	$$self.$$.update = () => {
    		if ($$self.$$.dirty & /*$activeRoute*/ 2) {
    			if ($activeRoute && $activeRoute.route === route) {
    				$$invalidate(2, routeParams = $activeRoute.params);
    			}
    		}

    		{
    			const { path, component, ...rest } = $$props;
    			$$invalidate(3, routeProps = rest);
    		}
    	};

    	$$props = exclude_internal_props($$props);

    	return [
    		component,
    		$activeRoute,
    		routeParams,
    		routeProps,
    		$location,
    		activeRoute,
    		location,
    		route,
    		path,
    		$$scope,
    		slots
    	];
    }

    class Route extends SvelteComponent {
    	constructor(options) {
    		super();
    		init(this, options, instance$h, create_fragment$i, safe_not_equal, { path: 8, component: 0 });
    	}
    }

    /**
     * An action to be added at a root element of your application to
     * capture all relative links and push them onto the history stack.
     *
     * Example:
     * ```html
     * <div use:links>
     *   <Router>
     *     <Route path="/" component={Home} />
     *     <Route path="/p/:projectId/:docId?" component={ProjectScreen} />
     *     {#each projects as project}
     *       <a href="/p/{project.id}">{project.title}</a>
     *     {/each}
     *   </Router>
     * </div>
     * ```
     */
    function links(node) {
      function findClosest(tagName, el) {
        while (el && el.tagName !== tagName) {
          el = el.parentNode;
        }
        return el;
      }

      function onClick(event) {
        const anchor = findClosest("A", event.target);

        if (
          anchor &&
          anchor.target === "" &&
          hostMatches(anchor) &&
          shouldNavigate(event) &&
          !anchor.hasAttribute("noroute")
        ) {
          event.preventDefault();
          navigate(anchor.pathname + anchor.search, { replace: anchor.hasAttribute("replace") });
        }
      }

      node.addEventListener("click", onClick);

      return {
        destroy() {
          node.removeEventListener("click", onClick);
        }
      };
    }

    var commonjsGlobal = typeof globalThis !== 'undefined' ? globalThis : typeof window !== 'undefined' ? window : typeof global !== 'undefined' ? global : typeof self !== 'undefined' ? self : {};

    function getDefaultExportFromCjs (x) {
    	return x && x.__esModule && Object.prototype.hasOwnProperty.call(x, 'default') ? x['default'] : x;
    }

    function getAugmentedNamespace(n) {
      if (n.__esModule) return n;
      var f = n.default;
    	if (typeof f == "function") {
    		var a = function a () {
    			if (this instanceof a) {
    				var args = [null];
    				args.push.apply(args, arguments);
    				var Ctor = Function.bind.apply(f, args);
    				return new Ctor();
    			}
    			return f.apply(this, arguments);
    		};
    		a.prototype = f.prototype;
      } else a = {};
      Object.defineProperty(a, '__esModule', {value: true});
    	Object.keys(n).forEach(function (k) {
    		var d = Object.getOwnPropertyDescriptor(n, k);
    		Object.defineProperty(a, k, d.get ? d : {
    			enumerable: true,
    			get: function () {
    				return n[k];
    			}
    		});
    	});
    	return a;
    }

    /**
     * Copies the values of `source` to `array`.
     *
     * @private
     * @param {Array} source The array to copy values from.
     * @param {Array} [array=[]] The array to copy values to.
     * @returns {Array} Returns `array`.
     */

    function copyArray$1(source, array) {
      var index = -1,
          length = source.length;

      array || (array = Array(length));
      while (++index < length) {
        array[index] = source[index];
      }
      return array;
    }

    var _copyArray = copyArray$1;

    /* Built-in method references for those with the same name as other `lodash` methods. */

    var nativeFloor = Math.floor,
        nativeRandom = Math.random;

    /**
     * The base implementation of `_.random` without support for returning
     * floating-point numbers.
     *
     * @private
     * @param {number} lower The lower bound.
     * @param {number} upper The upper bound.
     * @returns {number} Returns the random number.
     */
    function baseRandom$2(lower, upper) {
      return lower + nativeFloor(nativeRandom() * (upper - lower + 1));
    }

    var _baseRandom = baseRandom$2;

    var baseRandom$1 = _baseRandom;

    /**
     * A specialized version of `_.shuffle` which mutates and sets the size of `array`.
     *
     * @private
     * @param {Array} array The array to shuffle.
     * @param {number} [size=array.length] The size of `array`.
     * @returns {Array} Returns `array`.
     */
    function shuffleSelf$2(array, size) {
      var index = -1,
          length = array.length,
          lastIndex = length - 1;

      size = size === undefined ? length : size;
      while (++index < size) {
        var rand = baseRandom$1(index, lastIndex),
            value = array[rand];

        array[rand] = array[index];
        array[index] = value;
      }
      array.length = size;
      return array;
    }

    var _shuffleSelf = shuffleSelf$2;

    var copyArray = _copyArray,
        shuffleSelf$1 = _shuffleSelf;

    /**
     * A specialized version of `_.shuffle` for arrays.
     *
     * @private
     * @param {Array} array The array to shuffle.
     * @returns {Array} Returns the new shuffled array.
     */
    function arrayShuffle$1(array) {
      return shuffleSelf$1(copyArray(array));
    }

    var _arrayShuffle = arrayShuffle$1;

    /**
     * A specialized version of `_.map` for arrays without support for iteratee
     * shorthands.
     *
     * @private
     * @param {Array} [array] The array to iterate over.
     * @param {Function} iteratee The function invoked per iteration.
     * @returns {Array} Returns the new mapped array.
     */

    function arrayMap$3(array, iteratee) {
      var index = -1,
          length = array == null ? 0 : array.length,
          result = Array(length);

      while (++index < length) {
        result[index] = iteratee(array[index], index, array);
      }
      return result;
    }

    var _arrayMap = arrayMap$3;

    var arrayMap$2 = _arrayMap;

    /**
     * The base implementation of `_.values` and `_.valuesIn` which creates an
     * array of `object` property values corresponding to the property names
     * of `props`.
     *
     * @private
     * @param {Object} object The object to query.
     * @param {Array} props The property names to get values for.
     * @returns {Object} Returns the array of property values.
     */
    function baseValues$1(object, props) {
      return arrayMap$2(props, function(key) {
        return object[key];
      });
    }

    var _baseValues = baseValues$1;

    /**
     * The base implementation of `_.times` without support for iteratee shorthands
     * or max array length checks.
     *
     * @private
     * @param {number} n The number of times to invoke `iteratee`.
     * @param {Function} iteratee The function invoked per iteration.
     * @returns {Array} Returns the array of results.
     */

    function baseTimes$1(n, iteratee) {
      var index = -1,
          result = Array(n);

      while (++index < n) {
        result[index] = iteratee(index);
      }
      return result;
    }

    var _baseTimes = baseTimes$1;

    /** Detect free variable `global` from Node.js. */

    var freeGlobal$1 = typeof commonjsGlobal == 'object' && commonjsGlobal && commonjsGlobal.Object === Object && commonjsGlobal;

    var _freeGlobal = freeGlobal$1;

    var freeGlobal = _freeGlobal;

    /** Detect free variable `self`. */
    var freeSelf = typeof self == 'object' && self && self.Object === Object && self;

    /** Used as a reference to the global object. */
    var root$9 = freeGlobal || freeSelf || Function('return this')();

    var _root = root$9;

    var root$8 = _root;

    /** Built-in value references. */
    var Symbol$6 = root$8.Symbol;

    var _Symbol = Symbol$6;

    var Symbol$5 = _Symbol;

    /** Used for built-in method references. */
    var objectProto$d = Object.prototype;

    /** Used to check objects for own properties. */
    var hasOwnProperty$b = objectProto$d.hasOwnProperty;

    /**
     * Used to resolve the
     * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
     * of values.
     */
    var nativeObjectToString$1 = objectProto$d.toString;

    /** Built-in value references. */
    var symToStringTag$1 = Symbol$5 ? Symbol$5.toStringTag : undefined;

    /**
     * A specialized version of `baseGetTag` which ignores `Symbol.toStringTag` values.
     *
     * @private
     * @param {*} value The value to query.
     * @returns {string} Returns the raw `toStringTag`.
     */
    function getRawTag$1(value) {
      var isOwn = hasOwnProperty$b.call(value, symToStringTag$1),
          tag = value[symToStringTag$1];

      try {
        value[symToStringTag$1] = undefined;
        var unmasked = true;
      } catch (e) {}

      var result = nativeObjectToString$1.call(value);
      if (unmasked) {
        if (isOwn) {
          value[symToStringTag$1] = tag;
        } else {
          delete value[symToStringTag$1];
        }
      }
      return result;
    }

    var _getRawTag = getRawTag$1;

    /** Used for built-in method references. */

    var objectProto$c = Object.prototype;

    /**
     * Used to resolve the
     * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
     * of values.
     */
    var nativeObjectToString = objectProto$c.toString;

    /**
     * Converts `value` to a string using `Object.prototype.toString`.
     *
     * @private
     * @param {*} value The value to convert.
     * @returns {string} Returns the converted string.
     */
    function objectToString$1(value) {
      return nativeObjectToString.call(value);
    }

    var _objectToString = objectToString$1;

    var Symbol$4 = _Symbol,
        getRawTag = _getRawTag,
        objectToString = _objectToString;

    /** `Object#toString` result references. */
    var nullTag = '[object Null]',
        undefinedTag = '[object Undefined]';

    /** Built-in value references. */
    var symToStringTag = Symbol$4 ? Symbol$4.toStringTag : undefined;

    /**
     * The base implementation of `getTag` without fallbacks for buggy environments.
     *
     * @private
     * @param {*} value The value to query.
     * @returns {string} Returns the `toStringTag`.
     */
    function baseGetTag$7(value) {
      if (value == null) {
        return value === undefined ? undefinedTag : nullTag;
      }
      return (symToStringTag && symToStringTag in Object(value))
        ? getRawTag(value)
        : objectToString(value);
    }

    var _baseGetTag = baseGetTag$7;

    /**
     * Checks if `value` is object-like. A value is object-like if it's not `null`
     * and has a `typeof` result of "object".
     *
     * @static
     * @memberOf _
     * @since 4.0.0
     * @category Lang
     * @param {*} value The value to check.
     * @returns {boolean} Returns `true` if `value` is object-like, else `false`.
     * @example
     *
     * _.isObjectLike({});
     * // => true
     *
     * _.isObjectLike([1, 2, 3]);
     * // => true
     *
     * _.isObjectLike(_.noop);
     * // => false
     *
     * _.isObjectLike(null);
     * // => false
     */

    function isObjectLike$7(value) {
      return value != null && typeof value == 'object';
    }

    var isObjectLike_1 = isObjectLike$7;

    var baseGetTag$6 = _baseGetTag,
        isObjectLike$6 = isObjectLike_1;

    /** `Object#toString` result references. */
    var argsTag$2 = '[object Arguments]';

    /**
     * The base implementation of `_.isArguments`.
     *
     * @private
     * @param {*} value The value to check.
     * @returns {boolean} Returns `true` if `value` is an `arguments` object,
     */
    function baseIsArguments$1(value) {
      return isObjectLike$6(value) && baseGetTag$6(value) == argsTag$2;
    }

    var _baseIsArguments = baseIsArguments$1;

    var baseIsArguments = _baseIsArguments,
        isObjectLike$5 = isObjectLike_1;

    /** Used for built-in method references. */
    var objectProto$b = Object.prototype;

    /** Used to check objects for own properties. */
    var hasOwnProperty$a = objectProto$b.hasOwnProperty;

    /** Built-in value references. */
    var propertyIsEnumerable$1 = objectProto$b.propertyIsEnumerable;

    /**
     * Checks if `value` is likely an `arguments` object.
     *
     * @static
     * @memberOf _
     * @since 0.1.0
     * @category Lang
     * @param {*} value The value to check.
     * @returns {boolean} Returns `true` if `value` is an `arguments` object,
     *  else `false`.
     * @example
     *
     * _.isArguments(function() { return arguments; }());
     * // => true
     *
     * _.isArguments([1, 2, 3]);
     * // => false
     */
    var isArguments$4 = baseIsArguments(function() { return arguments; }()) ? baseIsArguments : function(value) {
      return isObjectLike$5(value) && hasOwnProperty$a.call(value, 'callee') &&
        !propertyIsEnumerable$1.call(value, 'callee');
    };

    var isArguments_1 = isArguments$4;

    /**
     * Checks if `value` is classified as an `Array` object.
     *
     * @static
     * @memberOf _
     * @since 0.1.0
     * @category Lang
     * @param {*} value The value to check.
     * @returns {boolean} Returns `true` if `value` is an array, else `false`.
     * @example
     *
     * _.isArray([1, 2, 3]);
     * // => true
     *
     * _.isArray(document.body.children);
     * // => false
     *
     * _.isArray('abc');
     * // => false
     *
     * _.isArray(_.noop);
     * // => false
     */

    var isArray$g = Array.isArray;

    var isArray_1 = isArray$g;

    var isBufferExports = {};
    var isBuffer$4 = {
      get exports(){ return isBufferExports; },
      set exports(v){ isBufferExports = v; },
    };

    /**
     * This method returns `false`.
     *
     * @static
     * @memberOf _
     * @since 4.13.0
     * @category Util
     * @returns {boolean} Returns `false`.
     * @example
     *
     * _.times(2, _.stubFalse);
     * // => [false, false]
     */

    function stubFalse() {
      return false;
    }

    var stubFalse_1 = stubFalse;

    (function (module, exports) {
    	var root = _root,
    	    stubFalse = stubFalse_1;

    	/** Detect free variable `exports`. */
    	var freeExports = exports && !exports.nodeType && exports;

    	/** Detect free variable `module`. */
    	var freeModule = freeExports && 'object' == 'object' && module && !module.nodeType && module;

    	/** Detect the popular CommonJS extension `module.exports`. */
    	var moduleExports = freeModule && freeModule.exports === freeExports;

    	/** Built-in value references. */
    	var Buffer = moduleExports ? root.Buffer : undefined;

    	/* Built-in method references for those with the same name as other `lodash` methods. */
    	var nativeIsBuffer = Buffer ? Buffer.isBuffer : undefined;

    	/**
    	 * Checks if `value` is a buffer.
    	 *
    	 * @static
    	 * @memberOf _
    	 * @since 4.3.0
    	 * @category Lang
    	 * @param {*} value The value to check.
    	 * @returns {boolean} Returns `true` if `value` is a buffer, else `false`.
    	 * @example
    	 *
    	 * _.isBuffer(new Buffer(2));
    	 * // => true
    	 *
    	 * _.isBuffer(new Uint8Array(2));
    	 * // => false
    	 */
    	var isBuffer = nativeIsBuffer || stubFalse;

    	module.exports = isBuffer;
    } (isBuffer$4, isBufferExports));

    /** Used as references for various `Number` constants. */

    var MAX_SAFE_INTEGER$1 = 9007199254740991;

    /** Used to detect unsigned integer values. */
    var reIsUint = /^(?:0|[1-9]\d*)$/;

    /**
     * Checks if `value` is a valid array-like index.
     *
     * @private
     * @param {*} value The value to check.
     * @param {number} [length=MAX_SAFE_INTEGER] The upper bounds of a valid index.
     * @returns {boolean} Returns `true` if `value` is a valid index, else `false`.
     */
    function isIndex$4(value, length) {
      var type = typeof value;
      length = length == null ? MAX_SAFE_INTEGER$1 : length;

      return !!length &&
        (type == 'number' ||
          (type != 'symbol' && reIsUint.test(value))) &&
            (value > -1 && value % 1 == 0 && value < length);
    }

    var _isIndex = isIndex$4;

    /** Used as references for various `Number` constants. */

    var MAX_SAFE_INTEGER = 9007199254740991;

    /**
     * Checks if `value` is a valid array-like length.
     *
     * **Note:** This method is loosely based on
     * [`ToLength`](http://ecma-international.org/ecma-262/7.0/#sec-tolength).
     *
     * @static
     * @memberOf _
     * @since 4.0.0
     * @category Lang
     * @param {*} value The value to check.
     * @returns {boolean} Returns `true` if `value` is a valid length, else `false`.
     * @example
     *
     * _.isLength(3);
     * // => true
     *
     * _.isLength(Number.MIN_VALUE);
     * // => false
     *
     * _.isLength(Infinity);
     * // => false
     *
     * _.isLength('3');
     * // => false
     */
    function isLength$3(value) {
      return typeof value == 'number' &&
        value > -1 && value % 1 == 0 && value <= MAX_SAFE_INTEGER;
    }

    var isLength_1 = isLength$3;

    var baseGetTag$5 = _baseGetTag,
        isLength$2 = isLength_1,
        isObjectLike$4 = isObjectLike_1;

    /** `Object#toString` result references. */
    var argsTag$1 = '[object Arguments]',
        arrayTag$1 = '[object Array]',
        boolTag$1 = '[object Boolean]',
        dateTag$1 = '[object Date]',
        errorTag$1 = '[object Error]',
        funcTag$1 = '[object Function]',
        mapTag$4 = '[object Map]',
        numberTag$1 = '[object Number]',
        objectTag$2 = '[object Object]',
        regexpTag$2 = '[object RegExp]',
        setTag$4 = '[object Set]',
        stringTag$2 = '[object String]',
        weakMapTag$1 = '[object WeakMap]';

    var arrayBufferTag$1 = '[object ArrayBuffer]',
        dataViewTag$2 = '[object DataView]',
        float32Tag = '[object Float32Array]',
        float64Tag = '[object Float64Array]',
        int8Tag = '[object Int8Array]',
        int16Tag = '[object Int16Array]',
        int32Tag = '[object Int32Array]',
        uint8Tag = '[object Uint8Array]',
        uint8ClampedTag = '[object Uint8ClampedArray]',
        uint16Tag = '[object Uint16Array]',
        uint32Tag = '[object Uint32Array]';

    /** Used to identify `toStringTag` values of typed arrays. */
    var typedArrayTags = {};
    typedArrayTags[float32Tag] = typedArrayTags[float64Tag] =
    typedArrayTags[int8Tag] = typedArrayTags[int16Tag] =
    typedArrayTags[int32Tag] = typedArrayTags[uint8Tag] =
    typedArrayTags[uint8ClampedTag] = typedArrayTags[uint16Tag] =
    typedArrayTags[uint32Tag] = true;
    typedArrayTags[argsTag$1] = typedArrayTags[arrayTag$1] =
    typedArrayTags[arrayBufferTag$1] = typedArrayTags[boolTag$1] =
    typedArrayTags[dataViewTag$2] = typedArrayTags[dateTag$1] =
    typedArrayTags[errorTag$1] = typedArrayTags[funcTag$1] =
    typedArrayTags[mapTag$4] = typedArrayTags[numberTag$1] =
    typedArrayTags[objectTag$2] = typedArrayTags[regexpTag$2] =
    typedArrayTags[setTag$4] = typedArrayTags[stringTag$2] =
    typedArrayTags[weakMapTag$1] = false;

    /**
     * The base implementation of `_.isTypedArray` without Node.js optimizations.
     *
     * @private
     * @param {*} value The value to check.
     * @returns {boolean} Returns `true` if `value` is a typed array, else `false`.
     */
    function baseIsTypedArray$1(value) {
      return isObjectLike$4(value) &&
        isLength$2(value.length) && !!typedArrayTags[baseGetTag$5(value)];
    }

    var _baseIsTypedArray = baseIsTypedArray$1;

    /**
     * The base implementation of `_.unary` without support for storing metadata.
     *
     * @private
     * @param {Function} func The function to cap arguments for.
     * @returns {Function} Returns the new capped function.
     */

    function baseUnary$3(func) {
      return function(value) {
        return func(value);
      };
    }

    var _baseUnary = baseUnary$3;

    var _nodeUtilExports = {};
    var _nodeUtil = {
      get exports(){ return _nodeUtilExports; },
      set exports(v){ _nodeUtilExports = v; },
    };

    (function (module, exports) {
    	var freeGlobal = _freeGlobal;

    	/** Detect free variable `exports`. */
    	var freeExports = exports && !exports.nodeType && exports;

    	/** Detect free variable `module`. */
    	var freeModule = freeExports && 'object' == 'object' && module && !module.nodeType && module;

    	/** Detect the popular CommonJS extension `module.exports`. */
    	var moduleExports = freeModule && freeModule.exports === freeExports;

    	/** Detect free variable `process` from Node.js. */
    	var freeProcess = moduleExports && freeGlobal.process;

    	/** Used to access faster Node.js helpers. */
    	var nodeUtil = (function() {
    	  try {
    	    // Use `util.types` for Node.js 10+.
    	    var types = freeModule && freeModule.require && freeModule.require('util').types;

    	    if (types) {
    	      return types;
    	    }

    	    // Legacy `process.binding('util')` for Node.js < 10.
    	    return freeProcess && freeProcess.binding && freeProcess.binding('util');
    	  } catch (e) {}
    	}());

    	module.exports = nodeUtil;
    } (_nodeUtil, _nodeUtilExports));

    var baseIsTypedArray = _baseIsTypedArray,
        baseUnary$2 = _baseUnary,
        nodeUtil$1 = _nodeUtilExports;

    /* Node.js helper references. */
    var nodeIsTypedArray = nodeUtil$1 && nodeUtil$1.isTypedArray;

    /**
     * Checks if `value` is classified as a typed array.
     *
     * @static
     * @memberOf _
     * @since 3.0.0
     * @category Lang
     * @param {*} value The value to check.
     * @returns {boolean} Returns `true` if `value` is a typed array, else `false`.
     * @example
     *
     * _.isTypedArray(new Uint8Array);
     * // => true
     *
     * _.isTypedArray([]);
     * // => false
     */
    var isTypedArray$3 = nodeIsTypedArray ? baseUnary$2(nodeIsTypedArray) : baseIsTypedArray;

    var isTypedArray_1 = isTypedArray$3;

    var baseTimes = _baseTimes,
        isArguments$3 = isArguments_1,
        isArray$f = isArray_1,
        isBuffer$3 = isBufferExports,
        isIndex$3 = _isIndex,
        isTypedArray$2 = isTypedArray_1;

    /** Used for built-in method references. */
    var objectProto$a = Object.prototype;

    /** Used to check objects for own properties. */
    var hasOwnProperty$9 = objectProto$a.hasOwnProperty;

    /**
     * Creates an array of the enumerable property names of the array-like `value`.
     *
     * @private
     * @param {*} value The value to query.
     * @param {boolean} inherited Specify returning inherited property names.
     * @returns {Array} Returns the array of property names.
     */
    function arrayLikeKeys$1(value, inherited) {
      var isArr = isArray$f(value),
          isArg = !isArr && isArguments$3(value),
          isBuff = !isArr && !isArg && isBuffer$3(value),
          isType = !isArr && !isArg && !isBuff && isTypedArray$2(value),
          skipIndexes = isArr || isArg || isBuff || isType,
          result = skipIndexes ? baseTimes(value.length, String) : [],
          length = result.length;

      for (var key in value) {
        if ((inherited || hasOwnProperty$9.call(value, key)) &&
            !(skipIndexes && (
               // Safari 9 has enumerable `arguments.length` in strict mode.
               key == 'length' ||
               // Node.js 0.10 has enumerable non-index properties on buffers.
               (isBuff && (key == 'offset' || key == 'parent')) ||
               // PhantomJS 2 has enumerable non-index properties on typed arrays.
               (isType && (key == 'buffer' || key == 'byteLength' || key == 'byteOffset')) ||
               // Skip index properties.
               isIndex$3(key, length)
            ))) {
          result.push(key);
        }
      }
      return result;
    }

    var _arrayLikeKeys = arrayLikeKeys$1;

    /** Used for built-in method references. */

    var objectProto$9 = Object.prototype;

    /**
     * Checks if `value` is likely a prototype object.
     *
     * @private
     * @param {*} value The value to check.
     * @returns {boolean} Returns `true` if `value` is a prototype, else `false`.
     */
    function isPrototype$2(value) {
      var Ctor = value && value.constructor,
          proto = (typeof Ctor == 'function' && Ctor.prototype) || objectProto$9;

      return value === proto;
    }

    var _isPrototype = isPrototype$2;

    /**
     * Creates a unary function that invokes `func` with its argument transformed.
     *
     * @private
     * @param {Function} func The function to wrap.
     * @param {Function} transform The argument transform.
     * @returns {Function} Returns the new function.
     */

    function overArg$1(func, transform) {
      return function(arg) {
        return func(transform(arg));
      };
    }

    var _overArg = overArg$1;

    var overArg = _overArg;

    /* Built-in method references for those with the same name as other `lodash` methods. */
    var nativeKeys$1 = overArg(Object.keys, Object);

    var _nativeKeys = nativeKeys$1;

    var isPrototype$1 = _isPrototype,
        nativeKeys = _nativeKeys;

    /** Used for built-in method references. */
    var objectProto$8 = Object.prototype;

    /** Used to check objects for own properties. */
    var hasOwnProperty$8 = objectProto$8.hasOwnProperty;

    /**
     * The base implementation of `_.keys` which doesn't treat sparse arrays as dense.
     *
     * @private
     * @param {Object} object The object to query.
     * @returns {Array} Returns the array of property names.
     */
    function baseKeys$3(object) {
      if (!isPrototype$1(object)) {
        return nativeKeys(object);
      }
      var result = [];
      for (var key in Object(object)) {
        if (hasOwnProperty$8.call(object, key) && key != 'constructor') {
          result.push(key);
        }
      }
      return result;
    }

    var _baseKeys = baseKeys$3;

    /**
     * Checks if `value` is the
     * [language type](http://www.ecma-international.org/ecma-262/7.0/#sec-ecmascript-language-types)
     * of `Object`. (e.g. arrays, functions, objects, regexes, `new Number(0)`, and `new String('')`)
     *
     * @static
     * @memberOf _
     * @since 0.1.0
     * @category Lang
     * @param {*} value The value to check.
     * @returns {boolean} Returns `true` if `value` is an object, else `false`.
     * @example
     *
     * _.isObject({});
     * // => true
     *
     * _.isObject([1, 2, 3]);
     * // => true
     *
     * _.isObject(_.noop);
     * // => true
     *
     * _.isObject(null);
     * // => false
     */

    function isObject$9(value) {
      var type = typeof value;
      return value != null && (type == 'object' || type == 'function');
    }

    var isObject_1 = isObject$9;

    var baseGetTag$4 = _baseGetTag,
        isObject$8 = isObject_1;

    /** `Object#toString` result references. */
    var asyncTag = '[object AsyncFunction]',
        funcTag = '[object Function]',
        genTag = '[object GeneratorFunction]',
        proxyTag = '[object Proxy]';

    /**
     * Checks if `value` is classified as a `Function` object.
     *
     * @static
     * @memberOf _
     * @since 0.1.0
     * @category Lang
     * @param {*} value The value to check.
     * @returns {boolean} Returns `true` if `value` is a function, else `false`.
     * @example
     *
     * _.isFunction(_);
     * // => true
     *
     * _.isFunction(/abc/);
     * // => false
     */
    function isFunction$3(value) {
      if (!isObject$8(value)) {
        return false;
      }
      // The use of `Object#toString` avoids issues with the `typeof` operator
      // in Safari 9 which returns 'object' for typed arrays and other constructors.
      var tag = baseGetTag$4(value);
      return tag == funcTag || tag == genTag || tag == asyncTag || tag == proxyTag;
    }

    var isFunction_1 = isFunction$3;

    var isFunction$2 = isFunction_1,
        isLength$1 = isLength_1;

    /**
     * Checks if `value` is array-like. A value is considered array-like if it's
     * not a function and has a `value.length` that's an integer greater than or
     * equal to `0` and less than or equal to `Number.MAX_SAFE_INTEGER`.
     *
     * @static
     * @memberOf _
     * @since 4.0.0
     * @category Lang
     * @param {*} value The value to check.
     * @returns {boolean} Returns `true` if `value` is array-like, else `false`.
     * @example
     *
     * _.isArrayLike([1, 2, 3]);
     * // => true
     *
     * _.isArrayLike(document.body.children);
     * // => true
     *
     * _.isArrayLike('abc');
     * // => true
     *
     * _.isArrayLike(_.noop);
     * // => false
     */
    function isArrayLike$6(value) {
      return value != null && isLength$1(value.length) && !isFunction$2(value);
    }

    var isArrayLike_1 = isArrayLike$6;

    var arrayLikeKeys = _arrayLikeKeys,
        baseKeys$2 = _baseKeys,
        isArrayLike$5 = isArrayLike_1;

    /**
     * Creates an array of the own enumerable property names of `object`.
     *
     * **Note:** Non-object values are coerced to objects. See the
     * [ES spec](http://ecma-international.org/ecma-262/7.0/#sec-object.keys)
     * for more details.
     *
     * @static
     * @since 0.1.0
     * @memberOf _
     * @category Object
     * @param {Object} object The object to query.
     * @returns {Array} Returns the array of property names.
     * @example
     *
     * function Foo() {
     *   this.a = 1;
     *   this.b = 2;
     * }
     *
     * Foo.prototype.c = 3;
     *
     * _.keys(new Foo);
     * // => ['a', 'b'] (iteration order is not guaranteed)
     *
     * _.keys('hi');
     * // => ['0', '1']
     */
    function keys$4(object) {
      return isArrayLike$5(object) ? arrayLikeKeys(object) : baseKeys$2(object);
    }

    var keys_1 = keys$4;

    var baseValues = _baseValues,
        keys$3 = keys_1;

    /**
     * Creates an array of the own enumerable string keyed property values of `object`.
     *
     * **Note:** Non-object values are coerced to objects.
     *
     * @static
     * @since 0.1.0
     * @memberOf _
     * @category Object
     * @param {Object} object The object to query.
     * @returns {Array} Returns the array of property values.
     * @example
     *
     * function Foo() {
     *   this.a = 1;
     *   this.b = 2;
     * }
     *
     * Foo.prototype.c = 3;
     *
     * _.values(new Foo);
     * // => [1, 2] (iteration order is not guaranteed)
     *
     * _.values('hi');
     * // => ['h', 'i']
     */
    function values$2(object) {
      return object == null ? [] : baseValues(object, keys$3(object));
    }

    var values_1 = values$2;

    var shuffleSelf = _shuffleSelf,
        values$1 = values_1;

    /**
     * The base implementation of `_.shuffle`.
     *
     * @private
     * @param {Array|Object} collection The collection to shuffle.
     * @returns {Array} Returns the new shuffled array.
     */
    function baseShuffle$1(collection) {
      return shuffleSelf(values$1(collection));
    }

    var _baseShuffle = baseShuffle$1;

    var arrayShuffle = _arrayShuffle,
        baseShuffle = _baseShuffle,
        isArray$e = isArray_1;

    /**
     * Creates an array of shuffled values, using a version of the
     * [Fisher-Yates shuffle](https://en.wikipedia.org/wiki/Fisher-Yates_shuffle).
     *
     * @static
     * @memberOf _
     * @since 0.1.0
     * @category Collection
     * @param {Array|Object} collection The collection to shuffle.
     * @returns {Array} Returns the new shuffled array.
     * @example
     *
     * _.shuffle([1, 2, 3, 4]);
     * // => [4, 1, 3, 2]
     */
    function shuffle(collection) {
      var func = isArray$e(collection) ? arrayShuffle : baseShuffle;
      return func(collection);
    }

    var shuffle_1 = shuffle;

    var baseGetTag$3 = _baseGetTag,
        isObjectLike$3 = isObjectLike_1;

    /** `Object#toString` result references. */
    var symbolTag$1 = '[object Symbol]';

    /**
     * Checks if `value` is classified as a `Symbol` primitive or object.
     *
     * @static
     * @memberOf _
     * @since 4.0.0
     * @category Lang
     * @param {*} value The value to check.
     * @returns {boolean} Returns `true` if `value` is a symbol, else `false`.
     * @example
     *
     * _.isSymbol(Symbol.iterator);
     * // => true
     *
     * _.isSymbol('abc');
     * // => false
     */
    function isSymbol$5(value) {
      return typeof value == 'symbol' ||
        (isObjectLike$3(value) && baseGetTag$3(value) == symbolTag$1);
    }

    var isSymbol_1 = isSymbol$5;

    var isArray$d = isArray_1,
        isSymbol$4 = isSymbol_1;

    /** Used to match property names within property paths. */
    var reIsDeepProp = /\.|\[(?:[^[\]]*|(["'])(?:(?!\1)[^\\]|\\.)*?\1)\]/,
        reIsPlainProp = /^\w*$/;

    /**
     * Checks if `value` is a property name and not a property path.
     *
     * @private
     * @param {*} value The value to check.
     * @param {Object} [object] The object to query keys on.
     * @returns {boolean} Returns `true` if `value` is a property name, else `false`.
     */
    function isKey$3(value, object) {
      if (isArray$d(value)) {
        return false;
      }
      var type = typeof value;
      if (type == 'number' || type == 'symbol' || type == 'boolean' ||
          value == null || isSymbol$4(value)) {
        return true;
      }
      return reIsPlainProp.test(value) || !reIsDeepProp.test(value) ||
        (object != null && value in Object(object));
    }

    var _isKey = isKey$3;

    var root$7 = _root;

    /** Used to detect overreaching core-js shims. */
    var coreJsData$1 = root$7['__core-js_shared__'];

    var _coreJsData = coreJsData$1;

    var coreJsData = _coreJsData;

    /** Used to detect methods masquerading as native. */
    var maskSrcKey = (function() {
      var uid = /[^.]+$/.exec(coreJsData && coreJsData.keys && coreJsData.keys.IE_PROTO || '');
      return uid ? ('Symbol(src)_1.' + uid) : '';
    }());

    /**
     * Checks if `func` has its source masked.
     *
     * @private
     * @param {Function} func The function to check.
     * @returns {boolean} Returns `true` if `func` is masked, else `false`.
     */
    function isMasked$1(func) {
      return !!maskSrcKey && (maskSrcKey in func);
    }

    var _isMasked = isMasked$1;

    /** Used for built-in method references. */

    var funcProto$1 = Function.prototype;

    /** Used to resolve the decompiled source of functions. */
    var funcToString$1 = funcProto$1.toString;

    /**
     * Converts `func` to its source code.
     *
     * @private
     * @param {Function} func The function to convert.
     * @returns {string} Returns the source code.
     */
    function toSource$2(func) {
      if (func != null) {
        try {
          return funcToString$1.call(func);
        } catch (e) {}
        try {
          return (func + '');
        } catch (e) {}
      }
      return '';
    }

    var _toSource = toSource$2;

    var isFunction$1 = isFunction_1,
        isMasked = _isMasked,
        isObject$7 = isObject_1,
        toSource$1 = _toSource;

    /**
     * Used to match `RegExp`
     * [syntax characters](http://ecma-international.org/ecma-262/7.0/#sec-patterns).
     */
    var reRegExpChar = /[\\^$.*+?()[\]{}|]/g;

    /** Used to detect host constructors (Safari). */
    var reIsHostCtor = /^\[object .+?Constructor\]$/;

    /** Used for built-in method references. */
    var funcProto = Function.prototype,
        objectProto$7 = Object.prototype;

    /** Used to resolve the decompiled source of functions. */
    var funcToString = funcProto.toString;

    /** Used to check objects for own properties. */
    var hasOwnProperty$7 = objectProto$7.hasOwnProperty;

    /** Used to detect if a method is native. */
    var reIsNative = RegExp('^' +
      funcToString.call(hasOwnProperty$7).replace(reRegExpChar, '\\$&')
      .replace(/hasOwnProperty|(function).*?(?=\\\()| for .+?(?=\\\])/g, '$1.*?') + '$'
    );

    /**
     * The base implementation of `_.isNative` without bad shim checks.
     *
     * @private
     * @param {*} value The value to check.
     * @returns {boolean} Returns `true` if `value` is a native function,
     *  else `false`.
     */
    function baseIsNative$1(value) {
      if (!isObject$7(value) || isMasked(value)) {
        return false;
      }
      var pattern = isFunction$1(value) ? reIsNative : reIsHostCtor;
      return pattern.test(toSource$1(value));
    }

    var _baseIsNative = baseIsNative$1;

    /**
     * Gets the value at `key` of `object`.
     *
     * @private
     * @param {Object} [object] The object to query.
     * @param {string} key The key of the property to get.
     * @returns {*} Returns the property value.
     */

    function getValue$1(object, key) {
      return object == null ? undefined : object[key];
    }

    var _getValue = getValue$1;

    var baseIsNative = _baseIsNative,
        getValue = _getValue;

    /**
     * Gets the native function at `key` of `object`.
     *
     * @private
     * @param {Object} object The object to query.
     * @param {string} key The key of the method to get.
     * @returns {*} Returns the function if it's native, else `undefined`.
     */
    function getNative$7(object, key) {
      var value = getValue(object, key);
      return baseIsNative(value) ? value : undefined;
    }

    var _getNative = getNative$7;

    var getNative$6 = _getNative;

    /* Built-in method references that are verified to be native. */
    var nativeCreate$4 = getNative$6(Object, 'create');

    var _nativeCreate = nativeCreate$4;

    var nativeCreate$3 = _nativeCreate;

    /**
     * Removes all key-value entries from the hash.
     *
     * @private
     * @name clear
     * @memberOf Hash
     */
    function hashClear$1() {
      this.__data__ = nativeCreate$3 ? nativeCreate$3(null) : {};
      this.size = 0;
    }

    var _hashClear = hashClear$1;

    /**
     * Removes `key` and its value from the hash.
     *
     * @private
     * @name delete
     * @memberOf Hash
     * @param {Object} hash The hash to modify.
     * @param {string} key The key of the value to remove.
     * @returns {boolean} Returns `true` if the entry was removed, else `false`.
     */

    function hashDelete$1(key) {
      var result = this.has(key) && delete this.__data__[key];
      this.size -= result ? 1 : 0;
      return result;
    }

    var _hashDelete = hashDelete$1;

    var nativeCreate$2 = _nativeCreate;

    /** Used to stand-in for `undefined` hash values. */
    var HASH_UNDEFINED$2 = '__lodash_hash_undefined__';

    /** Used for built-in method references. */
    var objectProto$6 = Object.prototype;

    /** Used to check objects for own properties. */
    var hasOwnProperty$6 = objectProto$6.hasOwnProperty;

    /**
     * Gets the hash value for `key`.
     *
     * @private
     * @name get
     * @memberOf Hash
     * @param {string} key The key of the value to get.
     * @returns {*} Returns the entry value.
     */
    function hashGet$1(key) {
      var data = this.__data__;
      if (nativeCreate$2) {
        var result = data[key];
        return result === HASH_UNDEFINED$2 ? undefined : result;
      }
      return hasOwnProperty$6.call(data, key) ? data[key] : undefined;
    }

    var _hashGet = hashGet$1;

    var nativeCreate$1 = _nativeCreate;

    /** Used for built-in method references. */
    var objectProto$5 = Object.prototype;

    /** Used to check objects for own properties. */
    var hasOwnProperty$5 = objectProto$5.hasOwnProperty;

    /**
     * Checks if a hash value for `key` exists.
     *
     * @private
     * @name has
     * @memberOf Hash
     * @param {string} key The key of the entry to check.
     * @returns {boolean} Returns `true` if an entry for `key` exists, else `false`.
     */
    function hashHas$1(key) {
      var data = this.__data__;
      return nativeCreate$1 ? (data[key] !== undefined) : hasOwnProperty$5.call(data, key);
    }

    var _hashHas = hashHas$1;

    var nativeCreate = _nativeCreate;

    /** Used to stand-in for `undefined` hash values. */
    var HASH_UNDEFINED$1 = '__lodash_hash_undefined__';

    /**
     * Sets the hash `key` to `value`.
     *
     * @private
     * @name set
     * @memberOf Hash
     * @param {string} key The key of the value to set.
     * @param {*} value The value to set.
     * @returns {Object} Returns the hash instance.
     */
    function hashSet$1(key, value) {
      var data = this.__data__;
      this.size += this.has(key) ? 0 : 1;
      data[key] = (nativeCreate && value === undefined) ? HASH_UNDEFINED$1 : value;
      return this;
    }

    var _hashSet = hashSet$1;

    var hashClear = _hashClear,
        hashDelete = _hashDelete,
        hashGet = _hashGet,
        hashHas = _hashHas,
        hashSet = _hashSet;

    /**
     * Creates a hash object.
     *
     * @private
     * @constructor
     * @param {Array} [entries] The key-value pairs to cache.
     */
    function Hash$1(entries) {
      var index = -1,
          length = entries == null ? 0 : entries.length;

      this.clear();
      while (++index < length) {
        var entry = entries[index];
        this.set(entry[0], entry[1]);
      }
    }

    // Add methods to `Hash`.
    Hash$1.prototype.clear = hashClear;
    Hash$1.prototype['delete'] = hashDelete;
    Hash$1.prototype.get = hashGet;
    Hash$1.prototype.has = hashHas;
    Hash$1.prototype.set = hashSet;

    var _Hash = Hash$1;

    /**
     * Removes all key-value entries from the list cache.
     *
     * @private
     * @name clear
     * @memberOf ListCache
     */

    function listCacheClear$1() {
      this.__data__ = [];
      this.size = 0;
    }

    var _listCacheClear = listCacheClear$1;

    /**
     * Performs a
     * [`SameValueZero`](http://ecma-international.org/ecma-262/7.0/#sec-samevaluezero)
     * comparison between two values to determine if they are equivalent.
     *
     * @static
     * @memberOf _
     * @since 4.0.0
     * @category Lang
     * @param {*} value The value to compare.
     * @param {*} other The other value to compare.
     * @returns {boolean} Returns `true` if the values are equivalent, else `false`.
     * @example
     *
     * var object = { 'a': 1 };
     * var other = { 'a': 1 };
     *
     * _.eq(object, object);
     * // => true
     *
     * _.eq(object, other);
     * // => false
     *
     * _.eq('a', 'a');
     * // => true
     *
     * _.eq('a', Object('a'));
     * // => false
     *
     * _.eq(NaN, NaN);
     * // => true
     */

    function eq$3(value, other) {
      return value === other || (value !== value && other !== other);
    }

    var eq_1 = eq$3;

    var eq$2 = eq_1;

    /**
     * Gets the index at which the `key` is found in `array` of key-value pairs.
     *
     * @private
     * @param {Array} array The array to inspect.
     * @param {*} key The key to search for.
     * @returns {number} Returns the index of the matched value, else `-1`.
     */
    function assocIndexOf$4(array, key) {
      var length = array.length;
      while (length--) {
        if (eq$2(array[length][0], key)) {
          return length;
        }
      }
      return -1;
    }

    var _assocIndexOf = assocIndexOf$4;

    var assocIndexOf$3 = _assocIndexOf;

    /** Used for built-in method references. */
    var arrayProto$2 = Array.prototype;

    /** Built-in value references. */
    var splice$1 = arrayProto$2.splice;

    /**
     * Removes `key` and its value from the list cache.
     *
     * @private
     * @name delete
     * @memberOf ListCache
     * @param {string} key The key of the value to remove.
     * @returns {boolean} Returns `true` if the entry was removed, else `false`.
     */
    function listCacheDelete$1(key) {
      var data = this.__data__,
          index = assocIndexOf$3(data, key);

      if (index < 0) {
        return false;
      }
      var lastIndex = data.length - 1;
      if (index == lastIndex) {
        data.pop();
      } else {
        splice$1.call(data, index, 1);
      }
      --this.size;
      return true;
    }

    var _listCacheDelete = listCacheDelete$1;

    var assocIndexOf$2 = _assocIndexOf;

    /**
     * Gets the list cache value for `key`.
     *
     * @private
     * @name get
     * @memberOf ListCache
     * @param {string} key The key of the value to get.
     * @returns {*} Returns the entry value.
     */
    function listCacheGet$1(key) {
      var data = this.__data__,
          index = assocIndexOf$2(data, key);

      return index < 0 ? undefined : data[index][1];
    }

    var _listCacheGet = listCacheGet$1;

    var assocIndexOf$1 = _assocIndexOf;

    /**
     * Checks if a list cache value for `key` exists.
     *
     * @private
     * @name has
     * @memberOf ListCache
     * @param {string} key The key of the entry to check.
     * @returns {boolean} Returns `true` if an entry for `key` exists, else `false`.
     */
    function listCacheHas$1(key) {
      return assocIndexOf$1(this.__data__, key) > -1;
    }

    var _listCacheHas = listCacheHas$1;

    var assocIndexOf = _assocIndexOf;

    /**
     * Sets the list cache `key` to `value`.
     *
     * @private
     * @name set
     * @memberOf ListCache
     * @param {string} key The key of the value to set.
     * @param {*} value The value to set.
     * @returns {Object} Returns the list cache instance.
     */
    function listCacheSet$1(key, value) {
      var data = this.__data__,
          index = assocIndexOf(data, key);

      if (index < 0) {
        ++this.size;
        data.push([key, value]);
      } else {
        data[index][1] = value;
      }
      return this;
    }

    var _listCacheSet = listCacheSet$1;

    var listCacheClear = _listCacheClear,
        listCacheDelete = _listCacheDelete,
        listCacheGet = _listCacheGet,
        listCacheHas = _listCacheHas,
        listCacheSet = _listCacheSet;

    /**
     * Creates an list cache object.
     *
     * @private
     * @constructor
     * @param {Array} [entries] The key-value pairs to cache.
     */
    function ListCache$4(entries) {
      var index = -1,
          length = entries == null ? 0 : entries.length;

      this.clear();
      while (++index < length) {
        var entry = entries[index];
        this.set(entry[0], entry[1]);
      }
    }

    // Add methods to `ListCache`.
    ListCache$4.prototype.clear = listCacheClear;
    ListCache$4.prototype['delete'] = listCacheDelete;
    ListCache$4.prototype.get = listCacheGet;
    ListCache$4.prototype.has = listCacheHas;
    ListCache$4.prototype.set = listCacheSet;

    var _ListCache = ListCache$4;

    var getNative$5 = _getNative,
        root$6 = _root;

    /* Built-in method references that are verified to be native. */
    var Map$4 = getNative$5(root$6, 'Map');

    var _Map = Map$4;

    var Hash = _Hash,
        ListCache$3 = _ListCache,
        Map$3 = _Map;

    /**
     * Removes all key-value entries from the map.
     *
     * @private
     * @name clear
     * @memberOf MapCache
     */
    function mapCacheClear$1() {
      this.size = 0;
      this.__data__ = {
        'hash': new Hash,
        'map': new (Map$3 || ListCache$3),
        'string': new Hash
      };
    }

    var _mapCacheClear = mapCacheClear$1;

    /**
     * Checks if `value` is suitable for use as unique object key.
     *
     * @private
     * @param {*} value The value to check.
     * @returns {boolean} Returns `true` if `value` is suitable, else `false`.
     */

    function isKeyable$1(value) {
      var type = typeof value;
      return (type == 'string' || type == 'number' || type == 'symbol' || type == 'boolean')
        ? (value !== '__proto__')
        : (value === null);
    }

    var _isKeyable = isKeyable$1;

    var isKeyable = _isKeyable;

    /**
     * Gets the data for `map`.
     *
     * @private
     * @param {Object} map The map to query.
     * @param {string} key The reference key.
     * @returns {*} Returns the map data.
     */
    function getMapData$4(map, key) {
      var data = map.__data__;
      return isKeyable(key)
        ? data[typeof key == 'string' ? 'string' : 'hash']
        : data.map;
    }

    var _getMapData = getMapData$4;

    var getMapData$3 = _getMapData;

    /**
     * Removes `key` and its value from the map.
     *
     * @private
     * @name delete
     * @memberOf MapCache
     * @param {string} key The key of the value to remove.
     * @returns {boolean} Returns `true` if the entry was removed, else `false`.
     */
    function mapCacheDelete$1(key) {
      var result = getMapData$3(this, key)['delete'](key);
      this.size -= result ? 1 : 0;
      return result;
    }

    var _mapCacheDelete = mapCacheDelete$1;

    var getMapData$2 = _getMapData;

    /**
     * Gets the map value for `key`.
     *
     * @private
     * @name get
     * @memberOf MapCache
     * @param {string} key The key of the value to get.
     * @returns {*} Returns the entry value.
     */
    function mapCacheGet$1(key) {
      return getMapData$2(this, key).get(key);
    }

    var _mapCacheGet = mapCacheGet$1;

    var getMapData$1 = _getMapData;

    /**
     * Checks if a map value for `key` exists.
     *
     * @private
     * @name has
     * @memberOf MapCache
     * @param {string} key The key of the entry to check.
     * @returns {boolean} Returns `true` if an entry for `key` exists, else `false`.
     */
    function mapCacheHas$1(key) {
      return getMapData$1(this, key).has(key);
    }

    var _mapCacheHas = mapCacheHas$1;

    var getMapData = _getMapData;

    /**
     * Sets the map `key` to `value`.
     *
     * @private
     * @name set
     * @memberOf MapCache
     * @param {string} key The key of the value to set.
     * @param {*} value The value to set.
     * @returns {Object} Returns the map cache instance.
     */
    function mapCacheSet$1(key, value) {
      var data = getMapData(this, key),
          size = data.size;

      data.set(key, value);
      this.size += data.size == size ? 0 : 1;
      return this;
    }

    var _mapCacheSet = mapCacheSet$1;

    var mapCacheClear = _mapCacheClear,
        mapCacheDelete = _mapCacheDelete,
        mapCacheGet = _mapCacheGet,
        mapCacheHas = _mapCacheHas,
        mapCacheSet = _mapCacheSet;

    /**
     * Creates a map cache object to store key-value pairs.
     *
     * @private
     * @constructor
     * @param {Array} [entries] The key-value pairs to cache.
     */
    function MapCache$3(entries) {
      var index = -1,
          length = entries == null ? 0 : entries.length;

      this.clear();
      while (++index < length) {
        var entry = entries[index];
        this.set(entry[0], entry[1]);
      }
    }

    // Add methods to `MapCache`.
    MapCache$3.prototype.clear = mapCacheClear;
    MapCache$3.prototype['delete'] = mapCacheDelete;
    MapCache$3.prototype.get = mapCacheGet;
    MapCache$3.prototype.has = mapCacheHas;
    MapCache$3.prototype.set = mapCacheSet;

    var _MapCache = MapCache$3;

    var MapCache$2 = _MapCache;

    /** Error message constants. */
    var FUNC_ERROR_TEXT$2 = 'Expected a function';

    /**
     * Creates a function that memoizes the result of `func`. If `resolver` is
     * provided, it determines the cache key for storing the result based on the
     * arguments provided to the memoized function. By default, the first argument
     * provided to the memoized function is used as the map cache key. The `func`
     * is invoked with the `this` binding of the memoized function.
     *
     * **Note:** The cache is exposed as the `cache` property on the memoized
     * function. Its creation may be customized by replacing the `_.memoize.Cache`
     * constructor with one whose instances implement the
     * [`Map`](http://ecma-international.org/ecma-262/7.0/#sec-properties-of-the-map-prototype-object)
     * method interface of `clear`, `delete`, `get`, `has`, and `set`.
     *
     * @static
     * @memberOf _
     * @since 0.1.0
     * @category Function
     * @param {Function} func The function to have its output memoized.
     * @param {Function} [resolver] The function to resolve the cache key.
     * @returns {Function} Returns the new memoized function.
     * @example
     *
     * var object = { 'a': 1, 'b': 2 };
     * var other = { 'c': 3, 'd': 4 };
     *
     * var values = _.memoize(_.values);
     * values(object);
     * // => [1, 2]
     *
     * values(other);
     * // => [3, 4]
     *
     * object.a = 2;
     * values(object);
     * // => [1, 2]
     *
     * // Modify the result cache.
     * values.cache.set(object, ['a', 'b']);
     * values(object);
     * // => ['a', 'b']
     *
     * // Replace `_.memoize.Cache`.
     * _.memoize.Cache = WeakMap;
     */
    function memoize$1(func, resolver) {
      if (typeof func != 'function' || (resolver != null && typeof resolver != 'function')) {
        throw new TypeError(FUNC_ERROR_TEXT$2);
      }
      var memoized = function() {
        var args = arguments,
            key = resolver ? resolver.apply(this, args) : args[0],
            cache = memoized.cache;

        if (cache.has(key)) {
          return cache.get(key);
        }
        var result = func.apply(this, args);
        memoized.cache = cache.set(key, result) || cache;
        return result;
      };
      memoized.cache = new (memoize$1.Cache || MapCache$2);
      return memoized;
    }

    // Expose `MapCache`.
    memoize$1.Cache = MapCache$2;

    var memoize_1 = memoize$1;

    var memoize = memoize_1;

    /** Used as the maximum memoize cache size. */
    var MAX_MEMOIZE_SIZE = 500;

    /**
     * A specialized version of `_.memoize` which clears the memoized function's
     * cache when it exceeds `MAX_MEMOIZE_SIZE`.
     *
     * @private
     * @param {Function} func The function to have its output memoized.
     * @returns {Function} Returns the new memoized function.
     */
    function memoizeCapped$1(func) {
      var result = memoize(func, function(key) {
        if (cache.size === MAX_MEMOIZE_SIZE) {
          cache.clear();
        }
        return key;
      });

      var cache = result.cache;
      return result;
    }

    var _memoizeCapped = memoizeCapped$1;

    var memoizeCapped = _memoizeCapped;

    /** Used to match property names within property paths. */
    var rePropName = /[^.[\]]+|\[(?:(-?\d+(?:\.\d+)?)|(["'])((?:(?!\2)[^\\]|\\.)*?)\2)\]|(?=(?:\.|\[\])(?:\.|\[\]|$))/g;

    /** Used to match backslashes in property paths. */
    var reEscapeChar = /\\(\\)?/g;

    /**
     * Converts `string` to a property path array.
     *
     * @private
     * @param {string} string The string to convert.
     * @returns {Array} Returns the property path array.
     */
    var stringToPath$1 = memoizeCapped(function(string) {
      var result = [];
      if (string.charCodeAt(0) === 46 /* . */) {
        result.push('');
      }
      string.replace(rePropName, function(match, number, quote, subString) {
        result.push(quote ? subString.replace(reEscapeChar, '$1') : (number || match));
      });
      return result;
    });

    var _stringToPath = stringToPath$1;

    var Symbol$3 = _Symbol,
        arrayMap$1 = _arrayMap,
        isArray$c = isArray_1,
        isSymbol$3 = isSymbol_1;

    /** Used as references for various `Number` constants. */
    var INFINITY$2 = 1 / 0;

    /** Used to convert symbols to primitives and strings. */
    var symbolProto$1 = Symbol$3 ? Symbol$3.prototype : undefined,
        symbolToString = symbolProto$1 ? symbolProto$1.toString : undefined;

    /**
     * The base implementation of `_.toString` which doesn't convert nullish
     * values to empty strings.
     *
     * @private
     * @param {*} value The value to process.
     * @returns {string} Returns the string.
     */
    function baseToString$2(value) {
      // Exit early for strings to avoid a performance hit in some environments.
      if (typeof value == 'string') {
        return value;
      }
      if (isArray$c(value)) {
        // Recursively convert values (susceptible to call stack limits).
        return arrayMap$1(value, baseToString$2) + '';
      }
      if (isSymbol$3(value)) {
        return symbolToString ? symbolToString.call(value) : '';
      }
      var result = (value + '');
      return (result == '0' && (1 / value) == -INFINITY$2) ? '-0' : result;
    }

    var _baseToString = baseToString$2;

    var baseToString$1 = _baseToString;

    /**
     * Converts `value` to a string. An empty string is returned for `null`
     * and `undefined` values. The sign of `-0` is preserved.
     *
     * @static
     * @memberOf _
     * @since 4.0.0
     * @category Lang
     * @param {*} value The value to convert.
     * @returns {string} Returns the converted string.
     * @example
     *
     * _.toString(null);
     * // => ''
     *
     * _.toString(-0);
     * // => '-0'
     *
     * _.toString([1, 2, 3]);
     * // => '1,2,3'
     */
    function toString$6(value) {
      return value == null ? '' : baseToString$1(value);
    }

    var toString_1 = toString$6;

    var isArray$b = isArray_1,
        isKey$2 = _isKey,
        stringToPath = _stringToPath,
        toString$5 = toString_1;

    /**
     * Casts `value` to a path array if it's not one.
     *
     * @private
     * @param {*} value The value to inspect.
     * @param {Object} [object] The object to query keys on.
     * @returns {Array} Returns the cast property path array.
     */
    function castPath$3(value, object) {
      if (isArray$b(value)) {
        return value;
      }
      return isKey$2(value, object) ? [value] : stringToPath(toString$5(value));
    }

    var _castPath = castPath$3;

    var isSymbol$2 = isSymbol_1;

    /** Used as references for various `Number` constants. */
    var INFINITY$1 = 1 / 0;

    /**
     * Converts `value` to a string key if it's not a string or symbol.
     *
     * @private
     * @param {*} value The value to inspect.
     * @returns {string|symbol} Returns the key.
     */
    function toKey$5(value) {
      if (typeof value == 'string' || isSymbol$2(value)) {
        return value;
      }
      var result = (value + '');
      return (result == '0' && (1 / value) == -INFINITY$1) ? '-0' : result;
    }

    var _toKey = toKey$5;

    var castPath$2 = _castPath,
        toKey$4 = _toKey;

    /**
     * The base implementation of `_.get` without support for default values.
     *
     * @private
     * @param {Object} object The object to query.
     * @param {Array|string} path The path of the property to get.
     * @returns {*} Returns the resolved value.
     */
    function baseGet$4(object, path) {
      path = castPath$2(path, object);

      var index = 0,
          length = path.length;

      while (object != null && index < length) {
        object = object[toKey$4(path[index++])];
      }
      return (index && index == length) ? object : undefined;
    }

    var _baseGet = baseGet$4;

    var baseGet$3 = _baseGet;

    /**
     * Gets the value at `path` of `object`. If the resolved value is
     * `undefined`, the `defaultValue` is returned in its place.
     *
     * @static
     * @memberOf _
     * @since 3.7.0
     * @category Object
     * @param {Object} object The object to query.
     * @param {Array|string} path The path of the property to get.
     * @param {*} [defaultValue] The value returned for `undefined` resolved values.
     * @returns {*} Returns the resolved value.
     * @example
     *
     * var object = { 'a': [{ 'b': { 'c': 3 } }] };
     *
     * _.get(object, 'a[0].b.c');
     * // => 3
     *
     * _.get(object, ['a', '0', 'b', 'c']);
     * // => 3
     *
     * _.get(object, 'a.b.c', 'default');
     * // => 'default'
     */
    function get$1(object, path, defaultValue) {
      var result = object == null ? undefined : baseGet$3(object, path);
      return result === undefined ? defaultValue : result;
    }

    var get_1 = get$1;

    /**
     * A specialized version of `_.reduce` for arrays without support for
     * iteratee shorthands.
     *
     * @private
     * @param {Array} [array] The array to iterate over.
     * @param {Function} iteratee The function invoked per iteration.
     * @param {*} [accumulator] The initial value.
     * @param {boolean} [initAccum] Specify using the first element of `array` as
     *  the initial value.
     * @returns {*} Returns the accumulated value.
     */

    function arrayReduce$1(array, iteratee, accumulator, initAccum) {
      var index = -1,
          length = array == null ? 0 : array.length;

      if (initAccum && length) {
        accumulator = array[++index];
      }
      while (++index < length) {
        accumulator = iteratee(accumulator, array[index], index, array);
      }
      return accumulator;
    }

    var _arrayReduce = arrayReduce$1;

    /**
     * The base implementation of `_.propertyOf` without support for deep paths.
     *
     * @private
     * @param {Object} object The object to query.
     * @returns {Function} Returns the new accessor function.
     */

    function basePropertyOf$1(object) {
      return function(key) {
        return object == null ? undefined : object[key];
      };
    }

    var _basePropertyOf = basePropertyOf$1;

    var basePropertyOf = _basePropertyOf;

    /** Used to map Latin Unicode letters to basic Latin letters. */
    var deburredLetters = {
      // Latin-1 Supplement block.
      '\xc0': 'A',  '\xc1': 'A', '\xc2': 'A', '\xc3': 'A', '\xc4': 'A', '\xc5': 'A',
      '\xe0': 'a',  '\xe1': 'a', '\xe2': 'a', '\xe3': 'a', '\xe4': 'a', '\xe5': 'a',
      '\xc7': 'C',  '\xe7': 'c',
      '\xd0': 'D',  '\xf0': 'd',
      '\xc8': 'E',  '\xc9': 'E', '\xca': 'E', '\xcb': 'E',
      '\xe8': 'e',  '\xe9': 'e', '\xea': 'e', '\xeb': 'e',
      '\xcc': 'I',  '\xcd': 'I', '\xce': 'I', '\xcf': 'I',
      '\xec': 'i',  '\xed': 'i', '\xee': 'i', '\xef': 'i',
      '\xd1': 'N',  '\xf1': 'n',
      '\xd2': 'O',  '\xd3': 'O', '\xd4': 'O', '\xd5': 'O', '\xd6': 'O', '\xd8': 'O',
      '\xf2': 'o',  '\xf3': 'o', '\xf4': 'o', '\xf5': 'o', '\xf6': 'o', '\xf8': 'o',
      '\xd9': 'U',  '\xda': 'U', '\xdb': 'U', '\xdc': 'U',
      '\xf9': 'u',  '\xfa': 'u', '\xfb': 'u', '\xfc': 'u',
      '\xdd': 'Y',  '\xfd': 'y', '\xff': 'y',
      '\xc6': 'Ae', '\xe6': 'ae',
      '\xde': 'Th', '\xfe': 'th',
      '\xdf': 'ss',
      // Latin Extended-A block.
      '\u0100': 'A',  '\u0102': 'A', '\u0104': 'A',
      '\u0101': 'a',  '\u0103': 'a', '\u0105': 'a',
      '\u0106': 'C',  '\u0108': 'C', '\u010a': 'C', '\u010c': 'C',
      '\u0107': 'c',  '\u0109': 'c', '\u010b': 'c', '\u010d': 'c',
      '\u010e': 'D',  '\u0110': 'D', '\u010f': 'd', '\u0111': 'd',
      '\u0112': 'E',  '\u0114': 'E', '\u0116': 'E', '\u0118': 'E', '\u011a': 'E',
      '\u0113': 'e',  '\u0115': 'e', '\u0117': 'e', '\u0119': 'e', '\u011b': 'e',
      '\u011c': 'G',  '\u011e': 'G', '\u0120': 'G', '\u0122': 'G',
      '\u011d': 'g',  '\u011f': 'g', '\u0121': 'g', '\u0123': 'g',
      '\u0124': 'H',  '\u0126': 'H', '\u0125': 'h', '\u0127': 'h',
      '\u0128': 'I',  '\u012a': 'I', '\u012c': 'I', '\u012e': 'I', '\u0130': 'I',
      '\u0129': 'i',  '\u012b': 'i', '\u012d': 'i', '\u012f': 'i', '\u0131': 'i',
      '\u0134': 'J',  '\u0135': 'j',
      '\u0136': 'K',  '\u0137': 'k', '\u0138': 'k',
      '\u0139': 'L',  '\u013b': 'L', '\u013d': 'L', '\u013f': 'L', '\u0141': 'L',
      '\u013a': 'l',  '\u013c': 'l', '\u013e': 'l', '\u0140': 'l', '\u0142': 'l',
      '\u0143': 'N',  '\u0145': 'N', '\u0147': 'N', '\u014a': 'N',
      '\u0144': 'n',  '\u0146': 'n', '\u0148': 'n', '\u014b': 'n',
      '\u014c': 'O',  '\u014e': 'O', '\u0150': 'O',
      '\u014d': 'o',  '\u014f': 'o', '\u0151': 'o',
      '\u0154': 'R',  '\u0156': 'R', '\u0158': 'R',
      '\u0155': 'r',  '\u0157': 'r', '\u0159': 'r',
      '\u015a': 'S',  '\u015c': 'S', '\u015e': 'S', '\u0160': 'S',
      '\u015b': 's',  '\u015d': 's', '\u015f': 's', '\u0161': 's',
      '\u0162': 'T',  '\u0164': 'T', '\u0166': 'T',
      '\u0163': 't',  '\u0165': 't', '\u0167': 't',
      '\u0168': 'U',  '\u016a': 'U', '\u016c': 'U', '\u016e': 'U', '\u0170': 'U', '\u0172': 'U',
      '\u0169': 'u',  '\u016b': 'u', '\u016d': 'u', '\u016f': 'u', '\u0171': 'u', '\u0173': 'u',
      '\u0174': 'W',  '\u0175': 'w',
      '\u0176': 'Y',  '\u0177': 'y', '\u0178': 'Y',
      '\u0179': 'Z',  '\u017b': 'Z', '\u017d': 'Z',
      '\u017a': 'z',  '\u017c': 'z', '\u017e': 'z',
      '\u0132': 'IJ', '\u0133': 'ij',
      '\u0152': 'Oe', '\u0153': 'oe',
      '\u0149': "'n", '\u017f': 's'
    };

    /**
     * Used by `_.deburr` to convert Latin-1 Supplement and Latin Extended-A
     * letters to basic Latin letters.
     *
     * @private
     * @param {string} letter The matched letter to deburr.
     * @returns {string} Returns the deburred letter.
     */
    var deburrLetter$1 = basePropertyOf(deburredLetters);

    var _deburrLetter = deburrLetter$1;

    var deburrLetter = _deburrLetter,
        toString$4 = toString_1;

    /** Used to match Latin Unicode letters (excluding mathematical operators). */
    var reLatin = /[\xc0-\xd6\xd8-\xf6\xf8-\xff\u0100-\u017f]/g;

    /** Used to compose unicode character classes. */
    var rsComboMarksRange$4 = '\\u0300-\\u036f',
        reComboHalfMarksRange$4 = '\\ufe20-\\ufe2f',
        rsComboSymbolsRange$4 = '\\u20d0-\\u20ff',
        rsComboRange$4 = rsComboMarksRange$4 + reComboHalfMarksRange$4 + rsComboSymbolsRange$4;

    /** Used to compose unicode capture groups. */
    var rsCombo$3 = '[' + rsComboRange$4 + ']';

    /**
     * Used to match [combining diacritical marks](https://en.wikipedia.org/wiki/Combining_Diacritical_Marks) and
     * [combining diacritical marks for symbols](https://en.wikipedia.org/wiki/Combining_Diacritical_Marks_for_Symbols).
     */
    var reComboMark = RegExp(rsCombo$3, 'g');

    /**
     * Deburrs `string` by converting
     * [Latin-1 Supplement](https://en.wikipedia.org/wiki/Latin-1_Supplement_(Unicode_block)#Character_table)
     * and [Latin Extended-A](https://en.wikipedia.org/wiki/Latin_Extended-A)
     * letters to basic Latin letters and removing
     * [combining diacritical marks](https://en.wikipedia.org/wiki/Combining_Diacritical_Marks).
     *
     * @static
     * @memberOf _
     * @since 3.0.0
     * @category String
     * @param {string} [string=''] The string to deburr.
     * @returns {string} Returns the deburred string.
     * @example
     *
     * _.deburr('déjà vu');
     * // => 'deja vu'
     */
    function deburr$1(string) {
      string = toString$4(string);
      return string && string.replace(reLatin, deburrLetter).replace(reComboMark, '');
    }

    var deburr_1 = deburr$1;

    /** Used to match words composed of alphanumeric characters. */

    var reAsciiWord = /[^\x00-\x2f\x3a-\x40\x5b-\x60\x7b-\x7f]+/g;

    /**
     * Splits an ASCII `string` into an array of its words.
     *
     * @private
     * @param {string} The string to inspect.
     * @returns {Array} Returns the words of `string`.
     */
    function asciiWords$1(string) {
      return string.match(reAsciiWord) || [];
    }

    var _asciiWords = asciiWords$1;

    /** Used to detect strings that need a more robust regexp to match words. */

    var reHasUnicodeWord = /[a-z][A-Z]|[A-Z]{2}[a-z]|[0-9][a-zA-Z]|[a-zA-Z][0-9]|[^a-zA-Z0-9 ]/;

    /**
     * Checks if `string` contains a word composed of Unicode symbols.
     *
     * @private
     * @param {string} string The string to inspect.
     * @returns {boolean} Returns `true` if a word is found, else `false`.
     */
    function hasUnicodeWord$1(string) {
      return reHasUnicodeWord.test(string);
    }

    var _hasUnicodeWord = hasUnicodeWord$1;

    /** Used to compose unicode character classes. */

    var rsAstralRange$3 = '\\ud800-\\udfff',
        rsComboMarksRange$3 = '\\u0300-\\u036f',
        reComboHalfMarksRange$3 = '\\ufe20-\\ufe2f',
        rsComboSymbolsRange$3 = '\\u20d0-\\u20ff',
        rsComboRange$3 = rsComboMarksRange$3 + reComboHalfMarksRange$3 + rsComboSymbolsRange$3,
        rsDingbatRange = '\\u2700-\\u27bf',
        rsLowerRange = 'a-z\\xdf-\\xf6\\xf8-\\xff',
        rsMathOpRange = '\\xac\\xb1\\xd7\\xf7',
        rsNonCharRange = '\\x00-\\x2f\\x3a-\\x40\\x5b-\\x60\\x7b-\\xbf',
        rsPunctuationRange = '\\u2000-\\u206f',
        rsSpaceRange = ' \\t\\x0b\\f\\xa0\\ufeff\\n\\r\\u2028\\u2029\\u1680\\u180e\\u2000\\u2001\\u2002\\u2003\\u2004\\u2005\\u2006\\u2007\\u2008\\u2009\\u200a\\u202f\\u205f\\u3000',
        rsUpperRange = 'A-Z\\xc0-\\xd6\\xd8-\\xde',
        rsVarRange$3 = '\\ufe0e\\ufe0f',
        rsBreakRange = rsMathOpRange + rsNonCharRange + rsPunctuationRange + rsSpaceRange;

    /** Used to compose unicode capture groups. */
    var rsApos$1 = "['\u2019]",
        rsBreak = '[' + rsBreakRange + ']',
        rsCombo$2 = '[' + rsComboRange$3 + ']',
        rsDigits = '\\d+',
        rsDingbat = '[' + rsDingbatRange + ']',
        rsLower = '[' + rsLowerRange + ']',
        rsMisc = '[^' + rsAstralRange$3 + rsBreakRange + rsDigits + rsDingbatRange + rsLowerRange + rsUpperRange + ']',
        rsFitz$2 = '\\ud83c[\\udffb-\\udfff]',
        rsModifier$2 = '(?:' + rsCombo$2 + '|' + rsFitz$2 + ')',
        rsNonAstral$2 = '[^' + rsAstralRange$3 + ']',
        rsRegional$2 = '(?:\\ud83c[\\udde6-\\uddff]){2}',
        rsSurrPair$2 = '[\\ud800-\\udbff][\\udc00-\\udfff]',
        rsUpper = '[' + rsUpperRange + ']',
        rsZWJ$3 = '\\u200d';

    /** Used to compose unicode regexes. */
    var rsMiscLower = '(?:' + rsLower + '|' + rsMisc + ')',
        rsMiscUpper = '(?:' + rsUpper + '|' + rsMisc + ')',
        rsOptContrLower = '(?:' + rsApos$1 + '(?:d|ll|m|re|s|t|ve))?',
        rsOptContrUpper = '(?:' + rsApos$1 + '(?:D|LL|M|RE|S|T|VE))?',
        reOptMod$2 = rsModifier$2 + '?',
        rsOptVar$2 = '[' + rsVarRange$3 + ']?',
        rsOptJoin$2 = '(?:' + rsZWJ$3 + '(?:' + [rsNonAstral$2, rsRegional$2, rsSurrPair$2].join('|') + ')' + rsOptVar$2 + reOptMod$2 + ')*',
        rsOrdLower = '\\d*(?:1st|2nd|3rd|(?![123])\\dth)(?=\\b|[A-Z_])',
        rsOrdUpper = '\\d*(?:1ST|2ND|3RD|(?![123])\\dTH)(?=\\b|[a-z_])',
        rsSeq$2 = rsOptVar$2 + reOptMod$2 + rsOptJoin$2,
        rsEmoji = '(?:' + [rsDingbat, rsRegional$2, rsSurrPair$2].join('|') + ')' + rsSeq$2;

    /** Used to match complex or compound words. */
    var reUnicodeWord = RegExp([
      rsUpper + '?' + rsLower + '+' + rsOptContrLower + '(?=' + [rsBreak, rsUpper, '$'].join('|') + ')',
      rsMiscUpper + '+' + rsOptContrUpper + '(?=' + [rsBreak, rsUpper + rsMiscLower, '$'].join('|') + ')',
      rsUpper + '?' + rsMiscLower + '+' + rsOptContrLower,
      rsUpper + '+' + rsOptContrUpper,
      rsOrdUpper,
      rsOrdLower,
      rsDigits,
      rsEmoji
    ].join('|'), 'g');

    /**
     * Splits a Unicode `string` into an array of its words.
     *
     * @private
     * @param {string} The string to inspect.
     * @returns {Array} Returns the words of `string`.
     */
    function unicodeWords$1(string) {
      return string.match(reUnicodeWord) || [];
    }

    var _unicodeWords = unicodeWords$1;

    var asciiWords = _asciiWords,
        hasUnicodeWord = _hasUnicodeWord,
        toString$3 = toString_1,
        unicodeWords = _unicodeWords;

    /**
     * Splits `string` into an array of its words.
     *
     * @static
     * @memberOf _
     * @since 3.0.0
     * @category String
     * @param {string} [string=''] The string to inspect.
     * @param {RegExp|string} [pattern] The pattern to match words.
     * @param- {Object} [guard] Enables use as an iteratee for methods like `_.map`.
     * @returns {Array} Returns the words of `string`.
     * @example
     *
     * _.words('fred, barney, & pebbles');
     * // => ['fred', 'barney', 'pebbles']
     *
     * _.words('fred, barney, & pebbles', /[^, ]+/g);
     * // => ['fred', 'barney', '&', 'pebbles']
     */
    function words$1(string, pattern, guard) {
      string = toString$3(string);
      pattern = guard ? undefined : pattern;

      if (pattern === undefined) {
        return hasUnicodeWord(string) ? unicodeWords(string) : asciiWords(string);
      }
      return string.match(pattern) || [];
    }

    var words_1 = words$1;

    var arrayReduce = _arrayReduce,
        deburr = deburr_1,
        words = words_1;

    /** Used to compose unicode capture groups. */
    var rsApos = "['\u2019]";

    /** Used to match apostrophes. */
    var reApos = RegExp(rsApos, 'g');

    /**
     * Creates a function like `_.camelCase`.
     *
     * @private
     * @param {Function} callback The function to combine each word.
     * @returns {Function} Returns the new compounder function.
     */
    function createCompounder$1(callback) {
      return function(string) {
        return arrayReduce(words(deburr(string).replace(reApos, '')), callback, '');
      };
    }

    var _createCompounder = createCompounder$1;

    var createCompounder = _createCompounder;

    /**
     * Converts `string` to
     * [kebab case](https://en.wikipedia.org/wiki/Letter_case#Special_case_styles).
     *
     * @static
     * @memberOf _
     * @since 3.0.0
     * @category String
     * @param {string} [string=''] The string to convert.
     * @returns {string} Returns the kebab cased string.
     * @example
     *
     * _.kebabCase('Foo Bar');
     * // => 'foo-bar'
     *
     * _.kebabCase('fooBar');
     * // => 'foo-bar'
     *
     * _.kebabCase('__FOO_BAR__');
     * // => 'foo-bar'
     */
    var kebabCase = createCompounder(function(result, word, index) {
      return result + (index ? '-' : '') + word.toLowerCase();
    });

    var kebabCase_1 = kebabCase;

    // *** GLOBALS

    const activeNavigation = writable('');

    const categoryList = writable([]);

    const satoshiList = writable([]);

    const globalLanguage = writable('english');

    const isTileView = writable(false);

    const isArabic = derived(
      globalLanguage,
      $globalLanguage => $globalLanguage === 'arabic'
    );

    const isEnglish = derived(
      globalLanguage,
      $globalLanguage => $globalLanguage === 'english'
    );

    const languagePrefix = derived(globalLanguage, $globalLanguage =>
      $globalLanguage === 'english' ? 'en' : 'ar'
    );

    const navigationColor = derived(
      [activeNavigation, categoryList, isTileView],
      ([$activeNavigation, $categoryList, $isTileView]) => {
        if ($isTileView) return 'rfgen-white'
        return get_1(
          $categoryList.find(c => c.categorySlug === kebabCase_1($activeNavigation)),
          'color',
          'rfgen-white'
        )
      }
    );

    const siteInfo = {
      title: {
        english: 'Rights of Future Generations',
        arabic: 'حقوق الأجيال القادمة'
      },
      satTitle: {
        english: 'Sharjah Architecture Triennial 2019',
        arabic: 'Sharjah Architecture Triennial 2019'
      },
      description: {
        english:
          'Rights of Future Generations is an invitation to radically rethink fundamental questions about architecture and its power to create and sustain alternative modes of existence.',
        arabic:
          'Rights of Future Generations is an invitation to radically rethink fundamental questions about architecture and its power to create and sustain alternative modes of existence.'
      },
      image: 'https://rfgen.net/img/rfgen.jpg'
    };

    const colorList = [
      'rfgen-blue',
      'rfgen-leaf',
      'rfgen-green',
      'rfgen-military',
      'rfgen-khaki',
      'rfgen-beige',
      'rfgen-red'
    ];

    const pageList = [
      {
        name: {
          english: 'Theme',
          arabic: 'الموضوع'
        },
        slug: 'theme'
      },
      {
        name: {
          english: 'Documentation',
          arabic: 'Documentation'
        },
        slug: 'documentation'
      },
      {
        name: {
          english: 'Venues',
          arabic: 'المواقع' //PLACEHOLDER
        },
        slug: 'venues'
      },
      {
        name: {
          english: 'Team',
          arabic: 'الفريق' //PLACEHOLDER
        },
        slug: 'team'
      },
      {
        name: {
          english: 'Press',
          arabic: 'الصحافة'
        },
        slug: 'press'
      },
      {
        name: {
          english: 'Contact',
          arabic: 'اتصل بنا'
        },
        slug: 'contact'
      }
    ];
    const categoryListDefaults = [
      {
        name: 'project',
        nameDisplay: {
          english: 'Projects',
          arabic: 'المشارع'
        },
        categorySlug: 'project',
        menuOrder: 1,
      },
      {
        name: 'discussion',
        nameDisplay: {
          english: 'Discussions',
          arabic: 'نقاشات'
        },
        categorySlug: 'discussion',
        menuOrder: 2,
      },
      {
        name: 'performance',
        nameDisplay: {
          english: 'Performances',
          arabic: 'عروض'
        },
        categorySlug: 'performance',
        menuOrder: 3,
      },
      {
        name: 'workingGroup',
        nameDisplay: {
          english: 'Working Group',
          arabic: 'مجموعة العمل'
        },
        categorySlug: 'working-group',
        menuOrder: 4
      },
      {
        name: 'writing',
        nameDisplay: {
          english: 'Writings',
          arabic: 'الكتابات'
        },
        categorySlug: 'writing',
        menuOrder: 5
      },
      {
        name: 'participant',
        nameDisplay: {
          english: 'Participants',
          arabic: 'المشاركون'
        },
        categorySlug: 'participant',
        menuOrder: 6,
      }
    ];

    const dustList = [
      '1.svg',
      '2.svg',
      '3.svg',
      '4.svg',
      '5.svg',
      '6.svg',
      '7.svg',
      '8.svg',
      '9.svg',
      '10.svg',
      '11.svg',
      '12.svg',
      '13.svg',
      '14.svg',
      '15.svg',
      '16.svg',
      '17.svg',
      '18.svg',
      '19.svg',
      '20.svg',
      '21.svg',
      '22.svg',
      '23.svg',
      '24.svg',
      '25.svg',
      '26.svg',
      '27.svg',
      '28.svg',
      '29.svg',
      '30.svg',
      '31.svg',
      '32.svg',
      '33.svg',
      '34.svg',
      '35.svg',
      '36.svg',
      '37.svg',
      '38.svg',
      '39.svg',
      '40.svg',
      '41.svg',
      '42.svg',
      '43.svg',
      '44.svg',
      '45.svg',
      '46.svg',
      '47.svg',
      '48.svg',
      '49.svg',
      '50.svg',
      '51.svg',
      '52.svg'
    ];

    /* src\Components\Navigation.svelte generated by Svelte v3.58.0 */

    function get_each_context$5(ctx, list, i) {
    	const child_ctx = ctx.slice();
    	child_ctx[7] = list[i];
    	return child_ctx;
    }

    function get_each_context_1$3(ctx, list, i) {
    	const child_ctx = ctx.slice();
    	child_ctx[10] = list[i];
    	return child_ctx;
    }

    // (399:8) {#if $isEnglish}
    function create_if_block_15$1(ctx) {
    	let t_value = siteInfo.title.english + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p: noop$1,
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (400:8) {#if $isArabic}
    function create_if_block_14$1(ctx) {
    	let t_value = siteInfo.title.arabic + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p: noop$1,
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (403:8) {#if !$isArabic}
    function create_if_block_13$1(ctx) {
    	let button;
    	let mounted;
    	let dispose;

    	return {
    		c() {
    			button = element("button");
    			button.textContent = "ﻉ";
    			attr(button, "class", "language-switch-button arabic svelte-1x4tpv9");
    		},
    		m(target, anchor) {
    			insert(target, button, anchor);

    			if (!mounted) {
    				dispose = listen$1(button, "click", /*changeLanguage*/ ctx[6]);
    				mounted = true;
    			}
    		},
    		p: noop$1,
    		d(detaching) {
    			if (detaching) detach(button);
    			mounted = false;
    			dispose();
    		}
    	};
    }

    // (410:8) {#if !$isEnglish}
    function create_if_block_12$3(ctx) {
    	let button;
    	let mounted;
    	let dispose;

    	return {
    		c() {
    			button = element("button");
    			button.textContent = "EN";
    			attr(button, "class", "language-switch-button svelte-1x4tpv9");
    		},
    		m(target, anchor) {
    			insert(target, button, anchor);

    			if (!mounted) {
    				dispose = listen$1(button, "click", /*changeLanguage*/ ctx[6]);
    				mounted = true;
    			}
    		},
    		p: noop$1,
    		d(detaching) {
    			if (detaching) detach(button);
    			mounted = false;
    			dispose();
    		}
    	};
    }

    // (424:14) {#if $isEnglish}
    function create_if_block_11$3(ctx) {
    	let t;

    	return {
    		c() {
    			t = text("Opening");
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (425:14) {#if $isArabic}
    function create_if_block_10$3(ctx) {
    	let t;

    	return {
    		c() {
    			t = text("برنامج الافتتاح");
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (434:14) {#if $isEnglish}
    function create_if_block_9$3(ctx) {
    	let t;

    	return {
    		c() {
    			t = text("Closing");
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (435:14) {#if $isArabic}
    function create_if_block_8$3(ctx) {
    	let t;

    	return {
    		c() {
    			t = text("الختام");
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (443:16) {#if $isEnglish}
    function create_if_block_7$3(ctx) {
    	let t_value = /*category*/ ctx[10].nameDisplay.english + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*$categoryList*/ 32 && t_value !== (t_value = /*category*/ ctx[10].nameDisplay.english + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (444:16) {#if $isArabic}
    function create_if_block_6$3(ctx) {
    	let t_value = /*category*/ ctx[10].nameDisplay.arabic + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*$categoryList*/ 32 && t_value !== (t_value = /*category*/ ctx[10].nameDisplay.arabic + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (438:10) {#each $categoryList as category}
    function create_each_block_1$3(ctx) {
    	let li;
    	let a;
    	let t0;
    	let a_href_value;
    	let t1;
    	let if_block0 = /*$isEnglish*/ ctx[0] && create_if_block_7$3(ctx);
    	let if_block1 = /*$isArabic*/ ctx[3] && create_if_block_6$3(ctx);

    	return {
    		c() {
    			li = element("li");
    			a = element("a");
    			if (if_block0) if_block0.c();
    			t0 = space();
    			if (if_block1) if_block1.c();
    			t1 = space();
    			attr(a, "href", a_href_value = "/" + /*$languagePrefix*/ ctx[2] + "/" + /*category*/ ctx[10].categorySlug);
    			attr(a, "class", "svelte-1x4tpv9");
    			toggle_class(a, "active", /*$activeNavigation*/ ctx[4] === /*category*/ ctx[10].categorySlug);
    			attr(li, "class", "category-menu-list-item svelte-1x4tpv9");
    			toggle_class(li, "arabic", /*$isArabic*/ ctx[3]);
    		},
    		m(target, anchor) {
    			insert(target, li, anchor);
    			append(li, a);
    			if (if_block0) if_block0.m(a, null);
    			append(a, t0);
    			if (if_block1) if_block1.m(a, null);
    			append(li, t1);
    		},
    		p(ctx, dirty) {
    			if (/*$isEnglish*/ ctx[0]) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);
    				} else {
    					if_block0 = create_if_block_7$3(ctx);
    					if_block0.c();
    					if_block0.m(a, t0);
    				}
    			} else if (if_block0) {
    				if_block0.d(1);
    				if_block0 = null;
    			}

    			if (/*$isArabic*/ ctx[3]) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);
    				} else {
    					if_block1 = create_if_block_6$3(ctx);
    					if_block1.c();
    					if_block1.m(a, null);
    				}
    			} else if (if_block1) {
    				if_block1.d(1);
    				if_block1 = null;
    			}

    			if (dirty & /*$languagePrefix, $categoryList*/ 36 && a_href_value !== (a_href_value = "/" + /*$languagePrefix*/ ctx[2] + "/" + /*category*/ ctx[10].categorySlug)) {
    				attr(a, "href", a_href_value);
    			}

    			if (dirty & /*$activeNavigation, $categoryList*/ 48) {
    				toggle_class(a, "active", /*$activeNavigation*/ ctx[4] === /*category*/ ctx[10].categorySlug);
    			}

    			if (dirty & /*$isArabic*/ 8) {
    				toggle_class(li, "arabic", /*$isArabic*/ ctx[3]);
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(li);
    			if (if_block0) if_block0.d();
    			if (if_block1) if_block1.d();
    		}
    	};
    }

    // (466:16) {#if $isEnglish}
    function create_if_block_5$4(ctx) {
    	let t_value = /*page*/ ctx[7].name.english + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p: noop$1,
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (467:16) {#if $isArabic}
    function create_if_block_4$4(ctx) {
    	let t_value = /*page*/ ctx[7].name.arabic + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p: noop$1,
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (461:10) {#each pageList as page}
    function create_each_block$5(ctx) {
    	let li;
    	let a;
    	let t;
    	let a_href_value;
    	let if_block0 = /*$isEnglish*/ ctx[0] && create_if_block_5$4(ctx);
    	let if_block1 = /*$isArabic*/ ctx[3] && create_if_block_4$4(ctx);

    	return {
    		c() {
    			li = element("li");
    			a = element("a");
    			if (if_block0) if_block0.c();
    			t = space();
    			if (if_block1) if_block1.c();
    			attr(a, "href", a_href_value = "/" + /*$languagePrefix*/ ctx[2] + "/page/" + /*page*/ ctx[7].slug);
    			attr(a, "class", "svelte-1x4tpv9");
    			toggle_class(a, "active", /*$activeNavigation*/ ctx[4] === /*page*/ ctx[7].slug);
    			attr(li, "class", "category-menu-list-item svelte-1x4tpv9");
    			toggle_class(li, "arabic", /*$isArabic*/ ctx[3]);
    		},
    		m(target, anchor) {
    			insert(target, li, anchor);
    			append(li, a);
    			if (if_block0) if_block0.m(a, null);
    			append(a, t);
    			if (if_block1) if_block1.m(a, null);
    		},
    		p(ctx, dirty) {
    			if (/*$isEnglish*/ ctx[0]) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);
    				} else {
    					if_block0 = create_if_block_5$4(ctx);
    					if_block0.c();
    					if_block0.m(a, t);
    				}
    			} else if (if_block0) {
    				if_block0.d(1);
    				if_block0 = null;
    			}

    			if (/*$isArabic*/ ctx[3]) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);
    				} else {
    					if_block1 = create_if_block_4$4(ctx);
    					if_block1.c();
    					if_block1.m(a, null);
    				}
    			} else if (if_block1) {
    				if_block1.d(1);
    				if_block1 = null;
    			}

    			if (dirty & /*$languagePrefix*/ 4 && a_href_value !== (a_href_value = "/" + /*$languagePrefix*/ ctx[2] + "/page/" + /*page*/ ctx[7].slug)) {
    				attr(a, "href", a_href_value);
    			}

    			if (dirty & /*$activeNavigation, pageList*/ 16) {
    				toggle_class(a, "active", /*$activeNavigation*/ ctx[4] === /*page*/ ctx[7].slug);
    			}

    			if (dirty & /*$isArabic*/ 8) {
    				toggle_class(li, "arabic", /*$isArabic*/ ctx[3]);
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(li);
    			if (if_block0) if_block0.d();
    			if (if_block1) if_block1.d();
    		}
    	};
    }

    // (479:14) {#if $isEnglish}
    function create_if_block_3$5(ctx) {
    	let t;

    	return {
    		c() {
    			t = text("#rfgen");
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (480:14) {#if $isArabic}
    function create_if_block_2$5(ctx) {
    	let t;

    	return {
    		c() {
    			t = text("rfgen#");
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (492:6) {#if $isEnglish}
    function create_if_block_1$b(ctx) {
    	let t;

    	return {
    		c() {
    			t = text("Sharjah Architecture Triennial");
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (493:6) {#if $isArabic}
    function create_if_block$d(ctx) {
    	let t;

    	return {
    		c() {
    			t = text("Sharjah Architecture Triennial");
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (395:0) <Router>
    function create_default_slot$6(ctx) {
    	let header;
    	let nav0;
    	let a0;
    	let t0;
    	let a0_href_value;
    	let t1;
    	let div0;
    	let t2;
    	let t3;
    	let menu0;
    	let ul0;
    	let li0;
    	let a1;
    	let t4;
    	let a1_href_value;
    	let t5;
    	let li1;
    	let a2;
    	let t6;
    	let a2_href_value;
    	let t7;
    	let t8;
    	let li2;
    	let t10;
    	let div1;
    	let header_class_value;
    	let t11;
    	let footer;
    	let nav1;
    	let menu1;
    	let ul1;
    	let t12;
    	let li3;
    	let a3;
    	let t13;
    	let t14;
    	let a4;
    	let t15;
    	let footer_class_value;
    	let mounted;
    	let dispose;
    	let if_block0 = /*$isEnglish*/ ctx[0] && create_if_block_15$1();
    	let if_block1 = /*$isArabic*/ ctx[3] && create_if_block_14$1();
    	let if_block2 = !/*$isArabic*/ ctx[3] && create_if_block_13$1(ctx);
    	let if_block3 = !/*$isEnglish*/ ctx[0] && create_if_block_12$3(ctx);
    	let if_block4 = /*$isEnglish*/ ctx[0] && create_if_block_11$3();
    	let if_block5 = /*$isArabic*/ ctx[3] && create_if_block_10$3();
    	let if_block6 = /*$isEnglish*/ ctx[0] && create_if_block_9$3();
    	let if_block7 = /*$isArabic*/ ctx[3] && create_if_block_8$3();
    	let each_value_1 = /*$categoryList*/ ctx[5];
    	let each_blocks_1 = [];

    	for (let i = 0; i < each_value_1.length; i += 1) {
    		each_blocks_1[i] = create_each_block_1$3(get_each_context_1$3(ctx, each_value_1, i));
    	}

    	let each_value = pageList;
    	let each_blocks = [];

    	for (let i = 0; i < each_value.length; i += 1) {
    		each_blocks[i] = create_each_block$5(get_each_context$5(ctx, each_value, i));
    	}

    	let if_block8 = /*$isEnglish*/ ctx[0] && create_if_block_3$5();
    	let if_block9 = /*$isArabic*/ ctx[3] && create_if_block_2$5();
    	let if_block10 = /*$isEnglish*/ ctx[0] && create_if_block_1$b();
    	let if_block11 = /*$isArabic*/ ctx[3] && create_if_block$d();

    	return {
    		c() {
    			header = element("header");
    			nav0 = element("nav");
    			a0 = element("a");
    			if (if_block0) if_block0.c();
    			t0 = space();
    			if (if_block1) if_block1.c();
    			t1 = space();
    			div0 = element("div");
    			if (if_block2) if_block2.c();
    			t2 = space();
    			if (if_block3) if_block3.c();
    			t3 = space();
    			menu0 = element("menu");
    			ul0 = element("ul");
    			li0 = element("li");
    			a1 = element("a");
    			if (if_block4) if_block4.c();
    			t4 = space();
    			if (if_block5) if_block5.c();
    			t5 = space();
    			li1 = element("li");
    			a2 = element("a");
    			if (if_block6) if_block6.c();
    			t6 = space();
    			if (if_block7) if_block7.c();
    			t7 = space();

    			for (let i = 0; i < each_blocks_1.length; i += 1) {
    				each_blocks_1[i].c();
    			}

    			t8 = space();
    			li2 = element("li");
    			li2.textContent = " ";
    			t10 = space();
    			div1 = element("div");
    			t11 = space();
    			footer = element("footer");
    			nav1 = element("nav");
    			menu1 = element("menu");
    			ul1 = element("ul");

    			for (let i = 0; i < each_blocks.length; i += 1) {
    				each_blocks[i].c();
    			}

    			t12 = space();
    			li3 = element("li");
    			a3 = element("a");
    			if (if_block8) if_block8.c();
    			t13 = space();
    			if (if_block9) if_block9.c();
    			t14 = space();
    			a4 = element("a");
    			if (if_block10) if_block10.c();
    			t15 = space();
    			if (if_block11) if_block11.c();
    			attr(a0, "href", a0_href_value = "/" + /*$languagePrefix*/ ctx[2] + "/");
    			attr(a0, "class", "text-logo svelte-1x4tpv9");
    			attr(div0, "class", "language-switch svelte-1x4tpv9");
    			toggle_class(div0, "arabic", /*$isArabic*/ ctx[3]);
    			attr(a1, "href", a1_href_value = "/" + /*$languagePrefix*/ ctx[2] + "/programme");
    			attr(a1, "class", "svelte-1x4tpv9");
    			toggle_class(a1, "active", /*$activeNavigation*/ ctx[4] === 'programme');
    			attr(li0, "class", "category-menu-list-item opening-programme-spacing-hack svelte-1x4tpv9");
    			toggle_class(li0, "arabic", /*$isArabic*/ ctx[3]);
    			attr(a2, "href", a2_href_value = "/" + /*$languagePrefix*/ ctx[2] + "/page/closing-programme");
    			attr(a2, "class", "svelte-1x4tpv9");
    			toggle_class(a2, "active", /*$activeNavigation*/ ctx[4] === 'closing-programme');
    			attr(li1, "class", "category-menu-list-item opening-programme-spacing-hack svelte-1x4tpv9");
    			toggle_class(li1, "arabic", /*$isArabic*/ ctx[3]);
    			attr(li2, "class", "category-menu-list-item block svelte-1x4tpv9");
    			attr(ul0, "class", "category-menu-list svelte-1x4tpv9");
    			attr(div1, "class", "category-menu-list-overlay svelte-1x4tpv9");
    			toggle_class(div1, "arabic", /*$isArabic*/ ctx[3]);
    			attr(menu0, "class", "category-menu svelte-1x4tpv9");
    			attr(header, "class", header_class_value = "navigation top " + /*$navigationColor*/ ctx[1] + " svelte-1x4tpv9");
    			attr(a3, "href", "https://www.instagram.com/explore/tags/rfgen/");
    			attr(a3, "target", "_blank");
    			attr(a3, "class", "force-ltr svelte-1x4tpv9");
    			attr(a3, "rel", "noreferrer");
    			attr(li3, "class", "category-menu-list-item social-media-spacing-hack svelte-1x4tpv9");
    			toggle_class(li3, "arabic", /*$isArabic*/ ctx[3]);
    			attr(ul1, "class", "category-menu-list svelte-1x4tpv9");
    			attr(menu1, "class", "category-menu bottom-menu svelte-1x4tpv9");
    			toggle_class(menu1, "arabic", /*$isArabic*/ ctx[3]);
    			attr(a4, "href", "https://www.sharjaharchitecture.org/");
    			attr(a4, "class", "sat-link svelte-1x4tpv9");
    			attr(a4, "target", "_blank");
    			attr(a4, "rel", "noreferrer");
    			toggle_class(a4, "arabic", /*$isArabic*/ ctx[3]);
    			attr(footer, "class", footer_class_value = "navigation bottom " + /*$navigationColor*/ ctx[1] + " svelte-1x4tpv9");
    		},
    		m(target, anchor) {
    			insert(target, header, anchor);
    			append(header, nav0);
    			append(nav0, a0);
    			if (if_block0) if_block0.m(a0, null);
    			append(a0, t0);
    			if (if_block1) if_block1.m(a0, null);
    			append(nav0, t1);
    			append(nav0, div0);
    			if (if_block2) if_block2.m(div0, null);
    			append(div0, t2);
    			if (if_block3) if_block3.m(div0, null);
    			append(nav0, t3);
    			append(nav0, menu0);
    			append(menu0, ul0);
    			append(ul0, li0);
    			append(li0, a1);
    			if (if_block4) if_block4.m(a1, null);
    			append(a1, t4);
    			if (if_block5) if_block5.m(a1, null);
    			append(ul0, t5);
    			append(ul0, li1);
    			append(li1, a2);
    			if (if_block6) if_block6.m(a2, null);
    			append(a2, t6);
    			if (if_block7) if_block7.m(a2, null);
    			append(ul0, t7);

    			for (let i = 0; i < each_blocks_1.length; i += 1) {
    				if (each_blocks_1[i]) {
    					each_blocks_1[i].m(ul0, null);
    				}
    			}

    			append(ul0, t8);
    			append(ul0, li2);
    			append(menu0, t10);
    			append(menu0, div1);
    			insert(target, t11, anchor);
    			insert(target, footer, anchor);
    			append(footer, nav1);
    			append(nav1, menu1);
    			append(menu1, ul1);

    			for (let i = 0; i < each_blocks.length; i += 1) {
    				if (each_blocks[i]) {
    					each_blocks[i].m(ul1, null);
    				}
    			}

    			append(ul1, t12);
    			append(ul1, li3);
    			append(li3, a3);
    			if (if_block8) if_block8.m(a3, null);
    			append(a3, t13);
    			if (if_block9) if_block9.m(a3, null);
    			append(footer, t14);
    			append(footer, a4);
    			if (if_block10) if_block10.m(a4, null);
    			append(a4, t15);
    			if (if_block11) if_block11.m(a4, null);

    			if (!mounted) {
    				dispose = [
    					action_destroyer(links.call(null, header)),
    					action_destroyer(links.call(null, footer))
    				];

    				mounted = true;
    			}
    		},
    		p(ctx, dirty) {
    			if (/*$isEnglish*/ ctx[0]) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);
    				} else {
    					if_block0 = create_if_block_15$1();
    					if_block0.c();
    					if_block0.m(a0, t0);
    				}
    			} else if (if_block0) {
    				if_block0.d(1);
    				if_block0 = null;
    			}

    			if (/*$isArabic*/ ctx[3]) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);
    				} else {
    					if_block1 = create_if_block_14$1();
    					if_block1.c();
    					if_block1.m(a0, null);
    				}
    			} else if (if_block1) {
    				if_block1.d(1);
    				if_block1 = null;
    			}

    			if (dirty & /*$languagePrefix*/ 4 && a0_href_value !== (a0_href_value = "/" + /*$languagePrefix*/ ctx[2] + "/")) {
    				attr(a0, "href", a0_href_value);
    			}

    			if (!/*$isArabic*/ ctx[3]) {
    				if (if_block2) {
    					if_block2.p(ctx, dirty);
    				} else {
    					if_block2 = create_if_block_13$1(ctx);
    					if_block2.c();
    					if_block2.m(div0, t2);
    				}
    			} else if (if_block2) {
    				if_block2.d(1);
    				if_block2 = null;
    			}

    			if (!/*$isEnglish*/ ctx[0]) {
    				if (if_block3) {
    					if_block3.p(ctx, dirty);
    				} else {
    					if_block3 = create_if_block_12$3(ctx);
    					if_block3.c();
    					if_block3.m(div0, null);
    				}
    			} else if (if_block3) {
    				if_block3.d(1);
    				if_block3 = null;
    			}

    			if (dirty & /*$isArabic*/ 8) {
    				toggle_class(div0, "arabic", /*$isArabic*/ ctx[3]);
    			}

    			if (/*$isEnglish*/ ctx[0]) {
    				if (if_block4) ; else {
    					if_block4 = create_if_block_11$3();
    					if_block4.c();
    					if_block4.m(a1, t4);
    				}
    			} else if (if_block4) {
    				if_block4.d(1);
    				if_block4 = null;
    			}

    			if (/*$isArabic*/ ctx[3]) {
    				if (if_block5) ; else {
    					if_block5 = create_if_block_10$3();
    					if_block5.c();
    					if_block5.m(a1, null);
    				}
    			} else if (if_block5) {
    				if_block5.d(1);
    				if_block5 = null;
    			}

    			if (dirty & /*$languagePrefix*/ 4 && a1_href_value !== (a1_href_value = "/" + /*$languagePrefix*/ ctx[2] + "/programme")) {
    				attr(a1, "href", a1_href_value);
    			}

    			if (dirty & /*$activeNavigation*/ 16) {
    				toggle_class(a1, "active", /*$activeNavigation*/ ctx[4] === 'programme');
    			}

    			if (dirty & /*$isArabic*/ 8) {
    				toggle_class(li0, "arabic", /*$isArabic*/ ctx[3]);
    			}

    			if (/*$isEnglish*/ ctx[0]) {
    				if (if_block6) ; else {
    					if_block6 = create_if_block_9$3();
    					if_block6.c();
    					if_block6.m(a2, t6);
    				}
    			} else if (if_block6) {
    				if_block6.d(1);
    				if_block6 = null;
    			}

    			if (/*$isArabic*/ ctx[3]) {
    				if (if_block7) ; else {
    					if_block7 = create_if_block_8$3();
    					if_block7.c();
    					if_block7.m(a2, null);
    				}
    			} else if (if_block7) {
    				if_block7.d(1);
    				if_block7 = null;
    			}

    			if (dirty & /*$languagePrefix*/ 4 && a2_href_value !== (a2_href_value = "/" + /*$languagePrefix*/ ctx[2] + "/page/closing-programme")) {
    				attr(a2, "href", a2_href_value);
    			}

    			if (dirty & /*$activeNavigation*/ 16) {
    				toggle_class(a2, "active", /*$activeNavigation*/ ctx[4] === 'closing-programme');
    			}

    			if (dirty & /*$isArabic*/ 8) {
    				toggle_class(li1, "arabic", /*$isArabic*/ ctx[3]);
    			}

    			if (dirty & /*$isArabic, $languagePrefix, $categoryList, $activeNavigation, $isEnglish*/ 61) {
    				each_value_1 = /*$categoryList*/ ctx[5];
    				let i;

    				for (i = 0; i < each_value_1.length; i += 1) {
    					const child_ctx = get_each_context_1$3(ctx, each_value_1, i);

    					if (each_blocks_1[i]) {
    						each_blocks_1[i].p(child_ctx, dirty);
    					} else {
    						each_blocks_1[i] = create_each_block_1$3(child_ctx);
    						each_blocks_1[i].c();
    						each_blocks_1[i].m(ul0, t8);
    					}
    				}

    				for (; i < each_blocks_1.length; i += 1) {
    					each_blocks_1[i].d(1);
    				}

    				each_blocks_1.length = each_value_1.length;
    			}

    			if (dirty & /*$isArabic*/ 8) {
    				toggle_class(div1, "arabic", /*$isArabic*/ ctx[3]);
    			}

    			if (dirty & /*$navigationColor*/ 2 && header_class_value !== (header_class_value = "navigation top " + /*$navigationColor*/ ctx[1] + " svelte-1x4tpv9")) {
    				attr(header, "class", header_class_value);
    			}

    			if (dirty & /*$isArabic, $languagePrefix, pageList, $activeNavigation, $isEnglish*/ 29) {
    				each_value = pageList;
    				let i;

    				for (i = 0; i < each_value.length; i += 1) {
    					const child_ctx = get_each_context$5(ctx, each_value, i);

    					if (each_blocks[i]) {
    						each_blocks[i].p(child_ctx, dirty);
    					} else {
    						each_blocks[i] = create_each_block$5(child_ctx);
    						each_blocks[i].c();
    						each_blocks[i].m(ul1, t12);
    					}
    				}

    				for (; i < each_blocks.length; i += 1) {
    					each_blocks[i].d(1);
    				}

    				each_blocks.length = each_value.length;
    			}

    			if (/*$isEnglish*/ ctx[0]) {
    				if (if_block8) ; else {
    					if_block8 = create_if_block_3$5();
    					if_block8.c();
    					if_block8.m(a3, t13);
    				}
    			} else if (if_block8) {
    				if_block8.d(1);
    				if_block8 = null;
    			}

    			if (/*$isArabic*/ ctx[3]) {
    				if (if_block9) ; else {
    					if_block9 = create_if_block_2$5();
    					if_block9.c();
    					if_block9.m(a3, null);
    				}
    			} else if (if_block9) {
    				if_block9.d(1);
    				if_block9 = null;
    			}

    			if (dirty & /*$isArabic*/ 8) {
    				toggle_class(li3, "arabic", /*$isArabic*/ ctx[3]);
    			}

    			if (dirty & /*$isArabic*/ 8) {
    				toggle_class(menu1, "arabic", /*$isArabic*/ ctx[3]);
    			}

    			if (/*$isEnglish*/ ctx[0]) {
    				if (if_block10) ; else {
    					if_block10 = create_if_block_1$b();
    					if_block10.c();
    					if_block10.m(a4, t15);
    				}
    			} else if (if_block10) {
    				if_block10.d(1);
    				if_block10 = null;
    			}

    			if (/*$isArabic*/ ctx[3]) {
    				if (if_block11) ; else {
    					if_block11 = create_if_block$d();
    					if_block11.c();
    					if_block11.m(a4, null);
    				}
    			} else if (if_block11) {
    				if_block11.d(1);
    				if_block11 = null;
    			}

    			if (dirty & /*$isArabic*/ 8) {
    				toggle_class(a4, "arabic", /*$isArabic*/ ctx[3]);
    			}

    			if (dirty & /*$navigationColor*/ 2 && footer_class_value !== (footer_class_value = "navigation bottom " + /*$navigationColor*/ ctx[1] + " svelte-1x4tpv9")) {
    				attr(footer, "class", footer_class_value);
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(header);
    			if (if_block0) if_block0.d();
    			if (if_block1) if_block1.d();
    			if (if_block2) if_block2.d();
    			if (if_block3) if_block3.d();
    			if (if_block4) if_block4.d();
    			if (if_block5) if_block5.d();
    			if (if_block6) if_block6.d();
    			if (if_block7) if_block7.d();
    			destroy_each(each_blocks_1, detaching);
    			if (detaching) detach(t11);
    			if (detaching) detach(footer);
    			destroy_each(each_blocks, detaching);
    			if (if_block8) if_block8.d();
    			if (if_block9) if_block9.d();
    			if (if_block10) if_block10.d();
    			if (if_block11) if_block11.d();
    			mounted = false;
    			run_all(dispose);
    		}
    	};
    }

    function create_fragment$h(ctx) {
    	let router;
    	let current;

    	router = new Router({
    			props: {
    				$$slots: { default: [create_default_slot$6] },
    				$$scope: { ctx }
    			}
    		});

    	return {
    		c() {
    			create_component(router.$$.fragment);
    		},
    		m(target, anchor) {
    			mount_component(router, target, anchor);
    			current = true;
    		},
    		p(ctx, [dirty]) {
    			const router_changes = {};

    			if (dirty & /*$$scope, $navigationColor, $isArabic, $isEnglish, $languagePrefix, $activeNavigation, $categoryList*/ 8255) {
    				router_changes.$$scope = { dirty, ctx };
    			}

    			router.$set(router_changes);
    		},
    		i(local) {
    			if (current) return;
    			transition_in(router.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(router.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			destroy_component(router, detaching);
    		}
    	};
    }

    function instance$g($$self, $$props, $$invalidate) {
    	let $isEnglish;
    	let $navigationColor;
    	let $languagePrefix;
    	let $isArabic;
    	let $activeNavigation;
    	let $categoryList;
    	component_subscribe($$self, isEnglish, $$value => $$invalidate(0, $isEnglish = $$value));
    	component_subscribe($$self, navigationColor, $$value => $$invalidate(1, $navigationColor = $$value));
    	component_subscribe($$self, languagePrefix, $$value => $$invalidate(2, $languagePrefix = $$value));
    	component_subscribe($$self, isArabic, $$value => $$invalidate(3, $isArabic = $$value));
    	component_subscribe($$self, activeNavigation, $$value => $$invalidate(4, $activeNavigation = $$value));
    	component_subscribe($$self, categoryList, $$value => $$invalidate(5, $categoryList = $$value));
    	const changeLanguage = () => globalLanguage.set($isEnglish ? "arabic" : "english");

    	return [
    		$isEnglish,
    		$navigationColor,
    		$languagePrefix,
    		$isArabic,
    		$activeNavigation,
    		$categoryList,
    		changeLanguage
    	];
    }

    class Navigation extends SvelteComponent {
    	constructor(options) {
    		super();
    		init(this, options, instance$g, create_fragment$h, safe_not_equal, {});
    	}
    }

    var root$5 = _root;

    /**
     * Gets the timestamp of the number of milliseconds that have elapsed since
     * the Unix epoch (1 January 1970 00:00:00 UTC).
     *
     * @static
     * @memberOf _
     * @since 2.4.0
     * @category Date
     * @returns {number} Returns the timestamp.
     * @example
     *
     * _.defer(function(stamp) {
     *   console.log(_.now() - stamp);
     * }, _.now());
     * // => Logs the number of milliseconds it took for the deferred invocation.
     */
    var now$1 = function() {
      return root$5.Date.now();
    };

    var now_1 = now$1;

    /** Used to match a single whitespace character. */

    var reWhitespace = /\s/;

    /**
     * Used by `_.trim` and `_.trimEnd` to get the index of the last non-whitespace
     * character of `string`.
     *
     * @private
     * @param {string} string The string to inspect.
     * @returns {number} Returns the index of the last non-whitespace character.
     */
    function trimmedEndIndex$1(string) {
      var index = string.length;

      while (index-- && reWhitespace.test(string.charAt(index))) {}
      return index;
    }

    var _trimmedEndIndex = trimmedEndIndex$1;

    var trimmedEndIndex = _trimmedEndIndex;

    /** Used to match leading whitespace. */
    var reTrimStart = /^\s+/;

    /**
     * The base implementation of `_.trim`.
     *
     * @private
     * @param {string} string The string to trim.
     * @returns {string} Returns the trimmed string.
     */
    function baseTrim$1(string) {
      return string
        ? string.slice(0, trimmedEndIndex(string) + 1).replace(reTrimStart, '')
        : string;
    }

    var _baseTrim = baseTrim$1;

    var baseTrim = _baseTrim,
        isObject$6 = isObject_1,
        isSymbol$1 = isSymbol_1;

    /** Used as references for various `Number` constants. */
    var NAN = 0 / 0;

    /** Used to detect bad signed hexadecimal string values. */
    var reIsBadHex = /^[-+]0x[0-9a-f]+$/i;

    /** Used to detect binary string values. */
    var reIsBinary = /^0b[01]+$/i;

    /** Used to detect octal string values. */
    var reIsOctal = /^0o[0-7]+$/i;

    /** Built-in method references without a dependency on `root`. */
    var freeParseInt = parseInt;

    /**
     * Converts `value` to a number.
     *
     * @static
     * @memberOf _
     * @since 4.0.0
     * @category Lang
     * @param {*} value The value to process.
     * @returns {number} Returns the number.
     * @example
     *
     * _.toNumber(3.2);
     * // => 3.2
     *
     * _.toNumber(Number.MIN_VALUE);
     * // => 5e-324
     *
     * _.toNumber(Infinity);
     * // => Infinity
     *
     * _.toNumber('3.2');
     * // => 3.2
     */
    function toNumber$2(value) {
      if (typeof value == 'number') {
        return value;
      }
      if (isSymbol$1(value)) {
        return NAN;
      }
      if (isObject$6(value)) {
        var other = typeof value.valueOf == 'function' ? value.valueOf() : value;
        value = isObject$6(other) ? (other + '') : other;
      }
      if (typeof value != 'string') {
        return value === 0 ? value : +value;
      }
      value = baseTrim(value);
      var isBinary = reIsBinary.test(value);
      return (isBinary || reIsOctal.test(value))
        ? freeParseInt(value.slice(2), isBinary ? 2 : 8)
        : (reIsBadHex.test(value) ? NAN : +value);
    }

    var toNumber_1 = toNumber$2;

    var isObject$5 = isObject_1,
        now = now_1,
        toNumber$1 = toNumber_1;

    /** Error message constants. */
    var FUNC_ERROR_TEXT$1 = 'Expected a function';

    /* Built-in method references for those with the same name as other `lodash` methods. */
    var nativeMax$2 = Math.max,
        nativeMin = Math.min;

    /**
     * Creates a debounced function that delays invoking `func` until after `wait`
     * milliseconds have elapsed since the last time the debounced function was
     * invoked. The debounced function comes with a `cancel` method to cancel
     * delayed `func` invocations and a `flush` method to immediately invoke them.
     * Provide `options` to indicate whether `func` should be invoked on the
     * leading and/or trailing edge of the `wait` timeout. The `func` is invoked
     * with the last arguments provided to the debounced function. Subsequent
     * calls to the debounced function return the result of the last `func`
     * invocation.
     *
     * **Note:** If `leading` and `trailing` options are `true`, `func` is
     * invoked on the trailing edge of the timeout only if the debounced function
     * is invoked more than once during the `wait` timeout.
     *
     * If `wait` is `0` and `leading` is `false`, `func` invocation is deferred
     * until to the next tick, similar to `setTimeout` with a timeout of `0`.
     *
     * See [David Corbacho's article](https://css-tricks.com/debouncing-throttling-explained-examples/)
     * for details over the differences between `_.debounce` and `_.throttle`.
     *
     * @static
     * @memberOf _
     * @since 0.1.0
     * @category Function
     * @param {Function} func The function to debounce.
     * @param {number} [wait=0] The number of milliseconds to delay.
     * @param {Object} [options={}] The options object.
     * @param {boolean} [options.leading=false]
     *  Specify invoking on the leading edge of the timeout.
     * @param {number} [options.maxWait]
     *  The maximum time `func` is allowed to be delayed before it's invoked.
     * @param {boolean} [options.trailing=true]
     *  Specify invoking on the trailing edge of the timeout.
     * @returns {Function} Returns the new debounced function.
     * @example
     *
     * // Avoid costly calculations while the window size is in flux.
     * jQuery(window).on('resize', _.debounce(calculateLayout, 150));
     *
     * // Invoke `sendMail` when clicked, debouncing subsequent calls.
     * jQuery(element).on('click', _.debounce(sendMail, 300, {
     *   'leading': true,
     *   'trailing': false
     * }));
     *
     * // Ensure `batchLog` is invoked once after 1 second of debounced calls.
     * var debounced = _.debounce(batchLog, 250, { 'maxWait': 1000 });
     * var source = new EventSource('/stream');
     * jQuery(source).on('message', debounced);
     *
     * // Cancel the trailing debounced invocation.
     * jQuery(window).on('popstate', debounced.cancel);
     */
    function debounce$1(func, wait, options) {
      var lastArgs,
          lastThis,
          maxWait,
          result,
          timerId,
          lastCallTime,
          lastInvokeTime = 0,
          leading = false,
          maxing = false,
          trailing = true;

      if (typeof func != 'function') {
        throw new TypeError(FUNC_ERROR_TEXT$1);
      }
      wait = toNumber$1(wait) || 0;
      if (isObject$5(options)) {
        leading = !!options.leading;
        maxing = 'maxWait' in options;
        maxWait = maxing ? nativeMax$2(toNumber$1(options.maxWait) || 0, wait) : maxWait;
        trailing = 'trailing' in options ? !!options.trailing : trailing;
      }

      function invokeFunc(time) {
        var args = lastArgs,
            thisArg = lastThis;

        lastArgs = lastThis = undefined;
        lastInvokeTime = time;
        result = func.apply(thisArg, args);
        return result;
      }

      function leadingEdge(time) {
        // Reset any `maxWait` timer.
        lastInvokeTime = time;
        // Start the timer for the trailing edge.
        timerId = setTimeout(timerExpired, wait);
        // Invoke the leading edge.
        return leading ? invokeFunc(time) : result;
      }

      function remainingWait(time) {
        var timeSinceLastCall = time - lastCallTime,
            timeSinceLastInvoke = time - lastInvokeTime,
            timeWaiting = wait - timeSinceLastCall;

        return maxing
          ? nativeMin(timeWaiting, maxWait - timeSinceLastInvoke)
          : timeWaiting;
      }

      function shouldInvoke(time) {
        var timeSinceLastCall = time - lastCallTime,
            timeSinceLastInvoke = time - lastInvokeTime;

        // Either this is the first call, activity has stopped and we're at the
        // trailing edge, the system time has gone backwards and we're treating
        // it as the trailing edge, or we've hit the `maxWait` limit.
        return (lastCallTime === undefined || (timeSinceLastCall >= wait) ||
          (timeSinceLastCall < 0) || (maxing && timeSinceLastInvoke >= maxWait));
      }

      function timerExpired() {
        var time = now();
        if (shouldInvoke(time)) {
          return trailingEdge(time);
        }
        // Restart the timer.
        timerId = setTimeout(timerExpired, remainingWait(time));
      }

      function trailingEdge(time) {
        timerId = undefined;

        // Only invoke if we have `lastArgs` which means `func` has been
        // debounced at least once.
        if (trailing && lastArgs) {
          return invokeFunc(time);
        }
        lastArgs = lastThis = undefined;
        return result;
      }

      function cancel() {
        if (timerId !== undefined) {
          clearTimeout(timerId);
        }
        lastInvokeTime = 0;
        lastArgs = lastCallTime = lastThis = timerId = undefined;
      }

      function flush() {
        return timerId === undefined ? result : trailingEdge(now());
      }

      function debounced() {
        var time = now(),
            isInvoking = shouldInvoke(time);

        lastArgs = arguments;
        lastThis = this;
        lastCallTime = time;

        if (isInvoking) {
          if (timerId === undefined) {
            return leadingEdge(lastCallTime);
          }
          if (maxing) {
            // Handle invocations in a tight loop.
            clearTimeout(timerId);
            timerId = setTimeout(timerExpired, wait);
            return invokeFunc(lastCallTime);
          }
        }
        if (timerId === undefined) {
          timerId = setTimeout(timerExpired, wait);
        }
        return result;
      }
      debounced.cancel = cancel;
      debounced.flush = flush;
      return debounced;
    }

    var debounce_1 = debounce$1;

    var debounce = debounce_1,
        isObject$4 = isObject_1;

    /** Error message constants. */
    var FUNC_ERROR_TEXT = 'Expected a function';

    /**
     * Creates a throttled function that only invokes `func` at most once per
     * every `wait` milliseconds. The throttled function comes with a `cancel`
     * method to cancel delayed `func` invocations and a `flush` method to
     * immediately invoke them. Provide `options` to indicate whether `func`
     * should be invoked on the leading and/or trailing edge of the `wait`
     * timeout. The `func` is invoked with the last arguments provided to the
     * throttled function. Subsequent calls to the throttled function return the
     * result of the last `func` invocation.
     *
     * **Note:** If `leading` and `trailing` options are `true`, `func` is
     * invoked on the trailing edge of the timeout only if the throttled function
     * is invoked more than once during the `wait` timeout.
     *
     * If `wait` is `0` and `leading` is `false`, `func` invocation is deferred
     * until to the next tick, similar to `setTimeout` with a timeout of `0`.
     *
     * See [David Corbacho's article](https://css-tricks.com/debouncing-throttling-explained-examples/)
     * for details over the differences between `_.throttle` and `_.debounce`.
     *
     * @static
     * @memberOf _
     * @since 0.1.0
     * @category Function
     * @param {Function} func The function to throttle.
     * @param {number} [wait=0] The number of milliseconds to throttle invocations to.
     * @param {Object} [options={}] The options object.
     * @param {boolean} [options.leading=true]
     *  Specify invoking on the leading edge of the timeout.
     * @param {boolean} [options.trailing=true]
     *  Specify invoking on the trailing edge of the timeout.
     * @returns {Function} Returns the new throttled function.
     * @example
     *
     * // Avoid excessively updating the position while scrolling.
     * jQuery(window).on('scroll', _.throttle(updatePosition, 100));
     *
     * // Invoke `renewToken` when the click event is fired, but not more than once every 5 minutes.
     * var throttled = _.throttle(renewToken, 300000, { 'trailing': false });
     * jQuery(element).on('click', throttled);
     *
     * // Cancel the trailing throttled invocation.
     * jQuery(window).on('popstate', throttled.cancel);
     */
    function throttle(func, wait, options) {
      var leading = true,
          trailing = true;

      if (typeof func != 'function') {
        throw new TypeError(FUNC_ERROR_TEXT);
      }
      if (isObject$4(options)) {
        leading = 'leading' in options ? !!options.leading : leading;
        trailing = 'trailing' in options ? !!options.trailing : trailing;
      }
      return debounce(func, wait, {
        'leading': leading,
        'maxWait': wait,
        'trailing': trailing
      });
    }

    var throttle_1 = throttle;

    var baseRandom = _baseRandom;

    /**
     * A specialized version of `_.sample` for arrays.
     *
     * @private
     * @param {Array} array The array to sample.
     * @returns {*} Returns the random element.
     */
    function arraySample$2(array) {
      var length = array.length;
      return length ? array[baseRandom(0, length - 1)] : undefined;
    }

    var _arraySample = arraySample$2;

    var arraySample$1 = _arraySample,
        values = values_1;

    /**
     * The base implementation of `_.sample`.
     *
     * @private
     * @param {Array|Object} collection The collection to sample.
     * @returns {*} Returns the random element.
     */
    function baseSample$1(collection) {
      return arraySample$1(values(collection));
    }

    var _baseSample = baseSample$1;

    var arraySample = _arraySample,
        baseSample = _baseSample,
        isArray$a = isArray_1;

    /**
     * Gets a random element from `collection`.
     *
     * @static
     * @memberOf _
     * @since 2.0.0
     * @category Collection
     * @param {Array|Object} collection The collection to sample.
     * @returns {*} Returns the random element.
     * @example
     *
     * _.sample([1, 2, 3, 4]);
     * // => 2
     */
    function sample$2(collection) {
      var func = isArray$a(collection) ? arraySample : baseSample;
      return func(collection);
    }

    var sample_1 = sample$2;

    var poissonProcess = {};

    var sample$1 = function (mean) {
      // Generate exponentially distributed variate.
      //
      // Inter-arrival times of events in Poisson process
      // are exponentially distributed.
      // mean = 1 / rate
      // Math.log(x) = natural logarithm of x
      return -Math.log(1 - Math.random()) * mean;
    };

    var sample = sample$1;

    var Process$1 = function (interval, fn) {
      // Parameters:
      //   interval
      //     number of milliseconds
      if (typeof interval !== 'number') {
        throw new Error(interval + ' should be a number.');
      }
      if (typeof fn !== 'function') {
        throw new Error('Callee ' + fn + ' should be a function.');
      }
      if (interval < 0) {
        throw new Error(interval + ' should be a non-negative number.');
      }
      this.interval = interval;
      this.fn = fn;
      this.timeout = null;
    };

    Process$1.prototype.start = function () {
      var dt = sample(this.interval);
      var self = this;
      this.timeout = setTimeout(function () {
        self.start();
        self.fn();
      }, dt);
    };

    Process$1.prototype.stop = function () {
      clearTimeout(this.timeout);
    };

    var Process_1 = Process$1;

    // generated by genversion
    var version = '1.0.1';

    var Process = Process_1;

    // Raw sampling function
    poissonProcess.sample = sample$1;

    // Semantic version, useful for inspection when version is not known.
    poissonProcess.version = version;

    // .create style contstructor
    poissonProcess.create = function (avgIntervalMs, triggedFn) {
      return new Process(avgIntervalMs, triggedFn);
    };

    /* src\Components\DustMachine.svelte generated by Svelte v3.58.0 */

    const { window: window_1 } = globals;

    function create_fragment$g(ctx) {
    	let section;
    	let mounted;
    	let dispose;

    	return {
    		c() {
    			section = element("section");
    			attr(section, "class", "dust-machine-container svelte-1gk3r2e");
    		},
    		m(target, anchor) {
    			insert(target, section, anchor);
    			/*section_binding*/ ctx[2](section);

    			if (!mounted) {
    				dispose = listen$1(window_1, "mousemove", throttle_1(/*handleMouseMove*/ ctx[1], 200));
    				mounted = true;
    			}
    		},
    		p: noop$1,
    		i: noop$1,
    		o: noop$1,
    		d(detaching) {
    			if (detaching) detach(section);
    			/*section_binding*/ ctx[2](null);
    			mounted = false;
    			dispose();
    		}
    	};
    }

    const DELAY = 10;
    const INTERVAL = 2500;

    function instance$f($$self, $$props, $$invalidate) {
    	let counter = 0;
    	let dustMachineContainer = {};

    	const hit = () => {
    		let newMote = document.createElement("img");
    		newMote.src = "/img/dust/" + sample_1(dustList);
    		newMote.classList = "mote";
    		newMote.style.top = Math.floor(Math.random() * window.innerHeight) + "px";
    		newMote.style.left = Math.floor(Math.random() * window.innerWidth) + "px";
    		dustMachineContainer.appendChild(newMote);
    	};

    	const pp = poissonProcess.create(INTERVAL, hit);

    	const startCountdown = delay => window.setInterval(
    		() => {
    			if (counter === delay) {
    				pp.start();
    			}

    			counter += 1;
    		},
    		1000
    	);

    	const handleMouseMove = () => {
    		counter = 0;
    		$$invalidate(0, dustMachineContainer.innerHTML = "", dustMachineContainer);
    		pp.stop();
    	};

    	onMount(async () => {
    		startCountdown(DELAY);
    	});

    	function section_binding($$value) {
    		binding_callbacks[$$value ? 'unshift' : 'push'](() => {
    			dustMachineContainer = $$value;
    			$$invalidate(0, dustMachineContainer);
    		});
    	}

    	return [dustMachineContainer, handleMouseMove, section_binding];
    }

    class DustMachine extends SvelteComponent {
    	constructor(options) {
    		super();
    		init(this, options, instance$f, create_fragment$g, safe_not_equal, {});
    	}
    }

    /**
     * The base implementation of `_.slice` without an iteratee call guard.
     *
     * @private
     * @param {Array} array The array to slice.
     * @param {number} [start=0] The start position.
     * @param {number} [end=array.length] The end position.
     * @returns {Array} Returns the slice of `array`.
     */

    function baseSlice$4(array, start, end) {
      var index = -1,
          length = array.length;

      if (start < 0) {
        start = -start > length ? 0 : (length + start);
      }
      end = end > length ? length : end;
      if (end < 0) {
        end += length;
      }
      length = start > end ? 0 : ((end - start) >>> 0);
      start >>>= 0;

      var result = Array(length);
      while (++index < length) {
        result[index] = array[index + start];
      }
      return result;
    }

    var _baseSlice = baseSlice$4;

    var eq$1 = eq_1,
        isArrayLike$4 = isArrayLike_1,
        isIndex$2 = _isIndex,
        isObject$3 = isObject_1;

    /**
     * Checks if the given arguments are from an iteratee call.
     *
     * @private
     * @param {*} value The potential iteratee value argument.
     * @param {*} index The potential iteratee index or key argument.
     * @param {*} object The potential iteratee object argument.
     * @returns {boolean} Returns `true` if the arguments are from an iteratee call,
     *  else `false`.
     */
    function isIterateeCall$2(value, index, object) {
      if (!isObject$3(object)) {
        return false;
      }
      var type = typeof index;
      if (type == 'number'
            ? (isArrayLike$4(object) && isIndex$2(index, object.length))
            : (type == 'string' && index in object)
          ) {
        return eq$1(object[index], value);
      }
      return false;
    }

    var _isIterateeCall = isIterateeCall$2;

    var toNumber = toNumber_1;

    /** Used as references for various `Number` constants. */
    var INFINITY = 1 / 0,
        MAX_INTEGER = 1.7976931348623157e+308;

    /**
     * Converts `value` to a finite number.
     *
     * @static
     * @memberOf _
     * @since 4.12.0
     * @category Lang
     * @param {*} value The value to convert.
     * @returns {number} Returns the converted number.
     * @example
     *
     * _.toFinite(3.2);
     * // => 3.2
     *
     * _.toFinite(Number.MIN_VALUE);
     * // => 5e-324
     *
     * _.toFinite(Infinity);
     * // => 1.7976931348623157e+308
     *
     * _.toFinite('3.2');
     * // => 3.2
     */
    function toFinite$1(value) {
      if (!value) {
        return value === 0 ? value : 0;
      }
      value = toNumber(value);
      if (value === INFINITY || value === -INFINITY) {
        var sign = (value < 0 ? -1 : 1);
        return sign * MAX_INTEGER;
      }
      return value === value ? value : 0;
    }

    var toFinite_1 = toFinite$1;

    var toFinite = toFinite_1;

    /**
     * Converts `value` to an integer.
     *
     * **Note:** This method is loosely based on
     * [`ToInteger`](http://www.ecma-international.org/ecma-262/7.0/#sec-tointeger).
     *
     * @static
     * @memberOf _
     * @since 4.0.0
     * @category Lang
     * @param {*} value The value to convert.
     * @returns {number} Returns the converted integer.
     * @example
     *
     * _.toInteger(3.2);
     * // => 3
     *
     * _.toInteger(Number.MIN_VALUE);
     * // => 0
     *
     * _.toInteger(Infinity);
     * // => 1.7976931348623157e+308
     *
     * _.toInteger('3.2');
     * // => 3
     */
    function toInteger$3(value) {
      var result = toFinite(value),
          remainder = result % 1;

      return result === result ? (remainder ? result - remainder : result) : 0;
    }

    var toInteger_1 = toInteger$3;

    var baseSlice$3 = _baseSlice,
        isIterateeCall$1 = _isIterateeCall,
        toInteger$2 = toInteger_1;

    /* Built-in method references for those with the same name as other `lodash` methods. */
    var nativeCeil = Math.ceil,
        nativeMax$1 = Math.max;

    /**
     * Creates an array of elements split into groups the length of `size`.
     * If `array` can't be split evenly, the final chunk will be the remaining
     * elements.
     *
     * @static
     * @memberOf _
     * @since 3.0.0
     * @category Array
     * @param {Array} array The array to process.
     * @param {number} [size=1] The length of each chunk
     * @param- {Object} [guard] Enables use as an iteratee for methods like `_.map`.
     * @returns {Array} Returns the new array of chunks.
     * @example
     *
     * _.chunk(['a', 'b', 'c', 'd'], 2);
     * // => [['a', 'b'], ['c', 'd']]
     *
     * _.chunk(['a', 'b', 'c', 'd'], 3);
     * // => [['a', 'b', 'c'], ['d']]
     */
    function chunk(array, size, guard) {
      if ((guard ? isIterateeCall$1(array, size, guard) : size === undefined)) {
        size = 1;
      } else {
        size = nativeMax$1(toInteger$2(size), 0);
      }
      var length = array == null ? 0 : array.length;
      if (!length || size < 1) {
        return [];
      }
      var index = 0,
          resIndex = 0,
          result = Array(nativeCeil(length / size));

      while (index < length) {
        result[resIndex++] = baseSlice$3(array, index, (index += size));
      }
      return result;
    }

    var chunk_1 = chunk;

    var ListCache$2 = _ListCache;

    /**
     * Removes all key-value entries from the stack.
     *
     * @private
     * @name clear
     * @memberOf Stack
     */
    function stackClear$1() {
      this.__data__ = new ListCache$2;
      this.size = 0;
    }

    var _stackClear = stackClear$1;

    /**
     * Removes `key` and its value from the stack.
     *
     * @private
     * @name delete
     * @memberOf Stack
     * @param {string} key The key of the value to remove.
     * @returns {boolean} Returns `true` if the entry was removed, else `false`.
     */

    function stackDelete$1(key) {
      var data = this.__data__,
          result = data['delete'](key);

      this.size = data.size;
      return result;
    }

    var _stackDelete = stackDelete$1;

    /**
     * Gets the stack value for `key`.
     *
     * @private
     * @name get
     * @memberOf Stack
     * @param {string} key The key of the value to get.
     * @returns {*} Returns the entry value.
     */

    function stackGet$1(key) {
      return this.__data__.get(key);
    }

    var _stackGet = stackGet$1;

    /**
     * Checks if a stack value for `key` exists.
     *
     * @private
     * @name has
     * @memberOf Stack
     * @param {string} key The key of the entry to check.
     * @returns {boolean} Returns `true` if an entry for `key` exists, else `false`.
     */

    function stackHas$1(key) {
      return this.__data__.has(key);
    }

    var _stackHas = stackHas$1;

    var ListCache$1 = _ListCache,
        Map$2 = _Map,
        MapCache$1 = _MapCache;

    /** Used as the size to enable large array optimizations. */
    var LARGE_ARRAY_SIZE = 200;

    /**
     * Sets the stack `key` to `value`.
     *
     * @private
     * @name set
     * @memberOf Stack
     * @param {string} key The key of the value to set.
     * @param {*} value The value to set.
     * @returns {Object} Returns the stack cache instance.
     */
    function stackSet$1(key, value) {
      var data = this.__data__;
      if (data instanceof ListCache$1) {
        var pairs = data.__data__;
        if (!Map$2 || (pairs.length < LARGE_ARRAY_SIZE - 1)) {
          pairs.push([key, value]);
          this.size = ++data.size;
          return this;
        }
        data = this.__data__ = new MapCache$1(pairs);
      }
      data.set(key, value);
      this.size = data.size;
      return this;
    }

    var _stackSet = stackSet$1;

    var ListCache = _ListCache,
        stackClear = _stackClear,
        stackDelete = _stackDelete,
        stackGet = _stackGet,
        stackHas = _stackHas,
        stackSet = _stackSet;

    /**
     * Creates a stack cache object to store key-value pairs.
     *
     * @private
     * @constructor
     * @param {Array} [entries] The key-value pairs to cache.
     */
    function Stack$2(entries) {
      var data = this.__data__ = new ListCache(entries);
      this.size = data.size;
    }

    // Add methods to `Stack`.
    Stack$2.prototype.clear = stackClear;
    Stack$2.prototype['delete'] = stackDelete;
    Stack$2.prototype.get = stackGet;
    Stack$2.prototype.has = stackHas;
    Stack$2.prototype.set = stackSet;

    var _Stack = Stack$2;

    /** Used to stand-in for `undefined` hash values. */

    var HASH_UNDEFINED = '__lodash_hash_undefined__';

    /**
     * Adds `value` to the array cache.
     *
     * @private
     * @name add
     * @memberOf SetCache
     * @alias push
     * @param {*} value The value to cache.
     * @returns {Object} Returns the cache instance.
     */
    function setCacheAdd$1(value) {
      this.__data__.set(value, HASH_UNDEFINED);
      return this;
    }

    var _setCacheAdd = setCacheAdd$1;

    /**
     * Checks if `value` is in the array cache.
     *
     * @private
     * @name has
     * @memberOf SetCache
     * @param {*} value The value to search for.
     * @returns {number} Returns `true` if `value` is found, else `false`.
     */

    function setCacheHas$1(value) {
      return this.__data__.has(value);
    }

    var _setCacheHas = setCacheHas$1;

    var MapCache = _MapCache,
        setCacheAdd = _setCacheAdd,
        setCacheHas = _setCacheHas;

    /**
     *
     * Creates an array cache object to store unique values.
     *
     * @private
     * @constructor
     * @param {Array} [values] The values to cache.
     */
    function SetCache$1(values) {
      var index = -1,
          length = values == null ? 0 : values.length;

      this.__data__ = new MapCache;
      while (++index < length) {
        this.add(values[index]);
      }
    }

    // Add methods to `SetCache`.
    SetCache$1.prototype.add = SetCache$1.prototype.push = setCacheAdd;
    SetCache$1.prototype.has = setCacheHas;

    var _SetCache = SetCache$1;

    /**
     * A specialized version of `_.some` for arrays without support for iteratee
     * shorthands.
     *
     * @private
     * @param {Array} [array] The array to iterate over.
     * @param {Function} predicate The function invoked per iteration.
     * @returns {boolean} Returns `true` if any element passes the predicate check,
     *  else `false`.
     */

    function arraySome$1(array, predicate) {
      var index = -1,
          length = array == null ? 0 : array.length;

      while (++index < length) {
        if (predicate(array[index], index, array)) {
          return true;
        }
      }
      return false;
    }

    var _arraySome = arraySome$1;

    /**
     * Checks if a `cache` value for `key` exists.
     *
     * @private
     * @param {Object} cache The cache to query.
     * @param {string} key The key of the entry to check.
     * @returns {boolean} Returns `true` if an entry for `key` exists, else `false`.
     */

    function cacheHas$1(cache, key) {
      return cache.has(key);
    }

    var _cacheHas = cacheHas$1;

    var SetCache = _SetCache,
        arraySome = _arraySome,
        cacheHas = _cacheHas;

    /** Used to compose bitmasks for value comparisons. */
    var COMPARE_PARTIAL_FLAG$5 = 1,
        COMPARE_UNORDERED_FLAG$3 = 2;

    /**
     * A specialized version of `baseIsEqualDeep` for arrays with support for
     * partial deep comparisons.
     *
     * @private
     * @param {Array} array The array to compare.
     * @param {Array} other The other array to compare.
     * @param {number} bitmask The bitmask flags. See `baseIsEqual` for more details.
     * @param {Function} customizer The function to customize comparisons.
     * @param {Function} equalFunc The function to determine equivalents of values.
     * @param {Object} stack Tracks traversed `array` and `other` objects.
     * @returns {boolean} Returns `true` if the arrays are equivalent, else `false`.
     */
    function equalArrays$2(array, other, bitmask, customizer, equalFunc, stack) {
      var isPartial = bitmask & COMPARE_PARTIAL_FLAG$5,
          arrLength = array.length,
          othLength = other.length;

      if (arrLength != othLength && !(isPartial && othLength > arrLength)) {
        return false;
      }
      // Check that cyclic values are equal.
      var arrStacked = stack.get(array);
      var othStacked = stack.get(other);
      if (arrStacked && othStacked) {
        return arrStacked == other && othStacked == array;
      }
      var index = -1,
          result = true,
          seen = (bitmask & COMPARE_UNORDERED_FLAG$3) ? new SetCache : undefined;

      stack.set(array, other);
      stack.set(other, array);

      // Ignore non-index properties.
      while (++index < arrLength) {
        var arrValue = array[index],
            othValue = other[index];

        if (customizer) {
          var compared = isPartial
            ? customizer(othValue, arrValue, index, other, array, stack)
            : customizer(arrValue, othValue, index, array, other, stack);
        }
        if (compared !== undefined) {
          if (compared) {
            continue;
          }
          result = false;
          break;
        }
        // Recursively compare arrays (susceptible to call stack limits).
        if (seen) {
          if (!arraySome(other, function(othValue, othIndex) {
                if (!cacheHas(seen, othIndex) &&
                    (arrValue === othValue || equalFunc(arrValue, othValue, bitmask, customizer, stack))) {
                  return seen.push(othIndex);
                }
              })) {
            result = false;
            break;
          }
        } else if (!(
              arrValue === othValue ||
                equalFunc(arrValue, othValue, bitmask, customizer, stack)
            )) {
          result = false;
          break;
        }
      }
      stack['delete'](array);
      stack['delete'](other);
      return result;
    }

    var _equalArrays = equalArrays$2;

    var root$4 = _root;

    /** Built-in value references. */
    var Uint8Array$1 = root$4.Uint8Array;

    var _Uint8Array = Uint8Array$1;

    /**
     * Converts `map` to its key-value pairs.
     *
     * @private
     * @param {Object} map The map to convert.
     * @returns {Array} Returns the key-value pairs.
     */

    function mapToArray$1(map) {
      var index = -1,
          result = Array(map.size);

      map.forEach(function(value, key) {
        result[++index] = [key, value];
      });
      return result;
    }

    var _mapToArray = mapToArray$1;

    /**
     * Converts `set` to an array of its values.
     *
     * @private
     * @param {Object} set The set to convert.
     * @returns {Array} Returns the values.
     */

    function setToArray$1(set) {
      var index = -1,
          result = Array(set.size);

      set.forEach(function(value) {
        result[++index] = value;
      });
      return result;
    }

    var _setToArray = setToArray$1;

    var Symbol$2 = _Symbol,
        Uint8Array = _Uint8Array,
        eq = eq_1,
        equalArrays$1 = _equalArrays,
        mapToArray = _mapToArray,
        setToArray = _setToArray;

    /** Used to compose bitmasks for value comparisons. */
    var COMPARE_PARTIAL_FLAG$4 = 1,
        COMPARE_UNORDERED_FLAG$2 = 2;

    /** `Object#toString` result references. */
    var boolTag = '[object Boolean]',
        dateTag = '[object Date]',
        errorTag = '[object Error]',
        mapTag$3 = '[object Map]',
        numberTag = '[object Number]',
        regexpTag$1 = '[object RegExp]',
        setTag$3 = '[object Set]',
        stringTag$1 = '[object String]',
        symbolTag = '[object Symbol]';

    var arrayBufferTag = '[object ArrayBuffer]',
        dataViewTag$1 = '[object DataView]';

    /** Used to convert symbols to primitives and strings. */
    var symbolProto = Symbol$2 ? Symbol$2.prototype : undefined,
        symbolValueOf = symbolProto ? symbolProto.valueOf : undefined;

    /**
     * A specialized version of `baseIsEqualDeep` for comparing objects of
     * the same `toStringTag`.
     *
     * **Note:** This function only supports comparing values with tags of
     * `Boolean`, `Date`, `Error`, `Number`, `RegExp`, or `String`.
     *
     * @private
     * @param {Object} object The object to compare.
     * @param {Object} other The other object to compare.
     * @param {string} tag The `toStringTag` of the objects to compare.
     * @param {number} bitmask The bitmask flags. See `baseIsEqual` for more details.
     * @param {Function} customizer The function to customize comparisons.
     * @param {Function} equalFunc The function to determine equivalents of values.
     * @param {Object} stack Tracks traversed `object` and `other` objects.
     * @returns {boolean} Returns `true` if the objects are equivalent, else `false`.
     */
    function equalByTag$1(object, other, tag, bitmask, customizer, equalFunc, stack) {
      switch (tag) {
        case dataViewTag$1:
          if ((object.byteLength != other.byteLength) ||
              (object.byteOffset != other.byteOffset)) {
            return false;
          }
          object = object.buffer;
          other = other.buffer;

        case arrayBufferTag:
          if ((object.byteLength != other.byteLength) ||
              !equalFunc(new Uint8Array(object), new Uint8Array(other))) {
            return false;
          }
          return true;

        case boolTag:
        case dateTag:
        case numberTag:
          // Coerce booleans to `1` or `0` and dates to milliseconds.
          // Invalid dates are coerced to `NaN`.
          return eq(+object, +other);

        case errorTag:
          return object.name == other.name && object.message == other.message;

        case regexpTag$1:
        case stringTag$1:
          // Coerce regexes to strings and treat strings, primitives and objects,
          // as equal. See http://www.ecma-international.org/ecma-262/7.0/#sec-regexp.prototype.tostring
          // for more details.
          return object == (other + '');

        case mapTag$3:
          var convert = mapToArray;

        case setTag$3:
          var isPartial = bitmask & COMPARE_PARTIAL_FLAG$4;
          convert || (convert = setToArray);

          if (object.size != other.size && !isPartial) {
            return false;
          }
          // Assume cyclic values are equal.
          var stacked = stack.get(object);
          if (stacked) {
            return stacked == other;
          }
          bitmask |= COMPARE_UNORDERED_FLAG$2;

          // Recursively compare objects (susceptible to call stack limits).
          stack.set(object, other);
          var result = equalArrays$1(convert(object), convert(other), bitmask, customizer, equalFunc, stack);
          stack['delete'](object);
          return result;

        case symbolTag:
          if (symbolValueOf) {
            return symbolValueOf.call(object) == symbolValueOf.call(other);
          }
      }
      return false;
    }

    var _equalByTag = equalByTag$1;

    /**
     * Appends the elements of `values` to `array`.
     *
     * @private
     * @param {Array} array The array to modify.
     * @param {Array} values The values to append.
     * @returns {Array} Returns `array`.
     */

    function arrayPush$2(array, values) {
      var index = -1,
          length = values.length,
          offset = array.length;

      while (++index < length) {
        array[offset + index] = values[index];
      }
      return array;
    }

    var _arrayPush = arrayPush$2;

    var arrayPush$1 = _arrayPush,
        isArray$9 = isArray_1;

    /**
     * The base implementation of `getAllKeys` and `getAllKeysIn` which uses
     * `keysFunc` and `symbolsFunc` to get the enumerable property names and
     * symbols of `object`.
     *
     * @private
     * @param {Object} object The object to query.
     * @param {Function} keysFunc The function to get the keys of `object`.
     * @param {Function} symbolsFunc The function to get the symbols of `object`.
     * @returns {Array} Returns the array of property names and symbols.
     */
    function baseGetAllKeys$1(object, keysFunc, symbolsFunc) {
      var result = keysFunc(object);
      return isArray$9(object) ? result : arrayPush$1(result, symbolsFunc(object));
    }

    var _baseGetAllKeys = baseGetAllKeys$1;

    /**
     * A specialized version of `_.filter` for arrays without support for
     * iteratee shorthands.
     *
     * @private
     * @param {Array} [array] The array to iterate over.
     * @param {Function} predicate The function invoked per iteration.
     * @returns {Array} Returns the new filtered array.
     */

    function arrayFilter$1(array, predicate) {
      var index = -1,
          length = array == null ? 0 : array.length,
          resIndex = 0,
          result = [];

      while (++index < length) {
        var value = array[index];
        if (predicate(value, index, array)) {
          result[resIndex++] = value;
        }
      }
      return result;
    }

    var _arrayFilter = arrayFilter$1;

    /**
     * This method returns a new empty array.
     *
     * @static
     * @memberOf _
     * @since 4.13.0
     * @category Util
     * @returns {Array} Returns the new empty array.
     * @example
     *
     * var arrays = _.times(2, _.stubArray);
     *
     * console.log(arrays);
     * // => [[], []]
     *
     * console.log(arrays[0] === arrays[1]);
     * // => false
     */

    function stubArray$1() {
      return [];
    }

    var stubArray_1 = stubArray$1;

    var arrayFilter = _arrayFilter,
        stubArray = stubArray_1;

    /** Used for built-in method references. */
    var objectProto$4 = Object.prototype;

    /** Built-in value references. */
    var propertyIsEnumerable = objectProto$4.propertyIsEnumerable;

    /* Built-in method references for those with the same name as other `lodash` methods. */
    var nativeGetSymbols = Object.getOwnPropertySymbols;

    /**
     * Creates an array of the own enumerable symbols of `object`.
     *
     * @private
     * @param {Object} object The object to query.
     * @returns {Array} Returns the array of symbols.
     */
    var getSymbols$1 = !nativeGetSymbols ? stubArray : function(object) {
      if (object == null) {
        return [];
      }
      object = Object(object);
      return arrayFilter(nativeGetSymbols(object), function(symbol) {
        return propertyIsEnumerable.call(object, symbol);
      });
    };

    var _getSymbols = getSymbols$1;

    var baseGetAllKeys = _baseGetAllKeys,
        getSymbols = _getSymbols,
        keys$2 = keys_1;

    /**
     * Creates an array of own enumerable property names and symbols of `object`.
     *
     * @private
     * @param {Object} object The object to query.
     * @returns {Array} Returns the array of property names and symbols.
     */
    function getAllKeys$1(object) {
      return baseGetAllKeys(object, keys$2, getSymbols);
    }

    var _getAllKeys = getAllKeys$1;

    var getAllKeys = _getAllKeys;

    /** Used to compose bitmasks for value comparisons. */
    var COMPARE_PARTIAL_FLAG$3 = 1;

    /** Used for built-in method references. */
    var objectProto$3 = Object.prototype;

    /** Used to check objects for own properties. */
    var hasOwnProperty$4 = objectProto$3.hasOwnProperty;

    /**
     * A specialized version of `baseIsEqualDeep` for objects with support for
     * partial deep comparisons.
     *
     * @private
     * @param {Object} object The object to compare.
     * @param {Object} other The other object to compare.
     * @param {number} bitmask The bitmask flags. See `baseIsEqual` for more details.
     * @param {Function} customizer The function to customize comparisons.
     * @param {Function} equalFunc The function to determine equivalents of values.
     * @param {Object} stack Tracks traversed `object` and `other` objects.
     * @returns {boolean} Returns `true` if the objects are equivalent, else `false`.
     */
    function equalObjects$1(object, other, bitmask, customizer, equalFunc, stack) {
      var isPartial = bitmask & COMPARE_PARTIAL_FLAG$3,
          objProps = getAllKeys(object),
          objLength = objProps.length,
          othProps = getAllKeys(other),
          othLength = othProps.length;

      if (objLength != othLength && !isPartial) {
        return false;
      }
      var index = objLength;
      while (index--) {
        var key = objProps[index];
        if (!(isPartial ? key in other : hasOwnProperty$4.call(other, key))) {
          return false;
        }
      }
      // Check that cyclic values are equal.
      var objStacked = stack.get(object);
      var othStacked = stack.get(other);
      if (objStacked && othStacked) {
        return objStacked == other && othStacked == object;
      }
      var result = true;
      stack.set(object, other);
      stack.set(other, object);

      var skipCtor = isPartial;
      while (++index < objLength) {
        key = objProps[index];
        var objValue = object[key],
            othValue = other[key];

        if (customizer) {
          var compared = isPartial
            ? customizer(othValue, objValue, key, other, object, stack)
            : customizer(objValue, othValue, key, object, other, stack);
        }
        // Recursively compare objects (susceptible to call stack limits).
        if (!(compared === undefined
              ? (objValue === othValue || equalFunc(objValue, othValue, bitmask, customizer, stack))
              : compared
            )) {
          result = false;
          break;
        }
        skipCtor || (skipCtor = key == 'constructor');
      }
      if (result && !skipCtor) {
        var objCtor = object.constructor,
            othCtor = other.constructor;

        // Non `Object` object instances with different constructors are not equal.
        if (objCtor != othCtor &&
            ('constructor' in object && 'constructor' in other) &&
            !(typeof objCtor == 'function' && objCtor instanceof objCtor &&
              typeof othCtor == 'function' && othCtor instanceof othCtor)) {
          result = false;
        }
      }
      stack['delete'](object);
      stack['delete'](other);
      return result;
    }

    var _equalObjects = equalObjects$1;

    var getNative$4 = _getNative,
        root$3 = _root;

    /* Built-in method references that are verified to be native. */
    var DataView$1 = getNative$4(root$3, 'DataView');

    var _DataView = DataView$1;

    var getNative$3 = _getNative,
        root$2 = _root;

    /* Built-in method references that are verified to be native. */
    var Promise$2 = getNative$3(root$2, 'Promise');

    var _Promise = Promise$2;

    var getNative$2 = _getNative,
        root$1 = _root;

    /* Built-in method references that are verified to be native. */
    var Set$2 = getNative$2(root$1, 'Set');

    var _Set = Set$2;

    var getNative$1 = _getNative,
        root = _root;

    /* Built-in method references that are verified to be native. */
    var WeakMap$1 = getNative$1(root, 'WeakMap');

    var _WeakMap = WeakMap$1;

    var DataView = _DataView,
        Map$1 = _Map,
        Promise$1 = _Promise,
        Set$1 = _Set,
        WeakMap = _WeakMap,
        baseGetTag$2 = _baseGetTag,
        toSource = _toSource;

    /** `Object#toString` result references. */
    var mapTag$2 = '[object Map]',
        objectTag$1 = '[object Object]',
        promiseTag = '[object Promise]',
        setTag$2 = '[object Set]',
        weakMapTag = '[object WeakMap]';

    var dataViewTag = '[object DataView]';

    /** Used to detect maps, sets, and weakmaps. */
    var dataViewCtorString = toSource(DataView),
        mapCtorString = toSource(Map$1),
        promiseCtorString = toSource(Promise$1),
        setCtorString = toSource(Set$1),
        weakMapCtorString = toSource(WeakMap);

    /**
     * Gets the `toStringTag` of `value`.
     *
     * @private
     * @param {*} value The value to query.
     * @returns {string} Returns the `toStringTag`.
     */
    var getTag$3 = baseGetTag$2;

    // Fallback for data views, maps, sets, and weak maps in IE 11 and promises in Node.js < 6.
    if ((DataView && getTag$3(new DataView(new ArrayBuffer(1))) != dataViewTag) ||
        (Map$1 && getTag$3(new Map$1) != mapTag$2) ||
        (Promise$1 && getTag$3(Promise$1.resolve()) != promiseTag) ||
        (Set$1 && getTag$3(new Set$1) != setTag$2) ||
        (WeakMap && getTag$3(new WeakMap) != weakMapTag)) {
      getTag$3 = function(value) {
        var result = baseGetTag$2(value),
            Ctor = result == objectTag$1 ? value.constructor : undefined,
            ctorString = Ctor ? toSource(Ctor) : '';

        if (ctorString) {
          switch (ctorString) {
            case dataViewCtorString: return dataViewTag;
            case mapCtorString: return mapTag$2;
            case promiseCtorString: return promiseTag;
            case setCtorString: return setTag$2;
            case weakMapCtorString: return weakMapTag;
          }
        }
        return result;
      };
    }

    var _getTag = getTag$3;

    var Stack$1 = _Stack,
        equalArrays = _equalArrays,
        equalByTag = _equalByTag,
        equalObjects = _equalObjects,
        getTag$2 = _getTag,
        isArray$8 = isArray_1,
        isBuffer$2 = isBufferExports,
        isTypedArray$1 = isTypedArray_1;

    /** Used to compose bitmasks for value comparisons. */
    var COMPARE_PARTIAL_FLAG$2 = 1;

    /** `Object#toString` result references. */
    var argsTag = '[object Arguments]',
        arrayTag = '[object Array]',
        objectTag = '[object Object]';

    /** Used for built-in method references. */
    var objectProto$2 = Object.prototype;

    /** Used to check objects for own properties. */
    var hasOwnProperty$3 = objectProto$2.hasOwnProperty;

    /**
     * A specialized version of `baseIsEqual` for arrays and objects which performs
     * deep comparisons and tracks traversed objects enabling objects with circular
     * references to be compared.
     *
     * @private
     * @param {Object} object The object to compare.
     * @param {Object} other The other object to compare.
     * @param {number} bitmask The bitmask flags. See `baseIsEqual` for more details.
     * @param {Function} customizer The function to customize comparisons.
     * @param {Function} equalFunc The function to determine equivalents of values.
     * @param {Object} [stack] Tracks traversed `object` and `other` objects.
     * @returns {boolean} Returns `true` if the objects are equivalent, else `false`.
     */
    function baseIsEqualDeep$1(object, other, bitmask, customizer, equalFunc, stack) {
      var objIsArr = isArray$8(object),
          othIsArr = isArray$8(other),
          objTag = objIsArr ? arrayTag : getTag$2(object),
          othTag = othIsArr ? arrayTag : getTag$2(other);

      objTag = objTag == argsTag ? objectTag : objTag;
      othTag = othTag == argsTag ? objectTag : othTag;

      var objIsObj = objTag == objectTag,
          othIsObj = othTag == objectTag,
          isSameTag = objTag == othTag;

      if (isSameTag && isBuffer$2(object)) {
        if (!isBuffer$2(other)) {
          return false;
        }
        objIsArr = true;
        objIsObj = false;
      }
      if (isSameTag && !objIsObj) {
        stack || (stack = new Stack$1);
        return (objIsArr || isTypedArray$1(object))
          ? equalArrays(object, other, bitmask, customizer, equalFunc, stack)
          : equalByTag(object, other, objTag, bitmask, customizer, equalFunc, stack);
      }
      if (!(bitmask & COMPARE_PARTIAL_FLAG$2)) {
        var objIsWrapped = objIsObj && hasOwnProperty$3.call(object, '__wrapped__'),
            othIsWrapped = othIsObj && hasOwnProperty$3.call(other, '__wrapped__');

        if (objIsWrapped || othIsWrapped) {
          var objUnwrapped = objIsWrapped ? object.value() : object,
              othUnwrapped = othIsWrapped ? other.value() : other;

          stack || (stack = new Stack$1);
          return equalFunc(objUnwrapped, othUnwrapped, bitmask, customizer, stack);
        }
      }
      if (!isSameTag) {
        return false;
      }
      stack || (stack = new Stack$1);
      return equalObjects(object, other, bitmask, customizer, equalFunc, stack);
    }

    var _baseIsEqualDeep = baseIsEqualDeep$1;

    var baseIsEqualDeep = _baseIsEqualDeep,
        isObjectLike$2 = isObjectLike_1;

    /**
     * The base implementation of `_.isEqual` which supports partial comparisons
     * and tracks traversed objects.
     *
     * @private
     * @param {*} value The value to compare.
     * @param {*} other The other value to compare.
     * @param {boolean} bitmask The bitmask flags.
     *  1 - Unordered comparison
     *  2 - Partial comparison
     * @param {Function} [customizer] The function to customize comparisons.
     * @param {Object} [stack] Tracks traversed `value` and `other` objects.
     * @returns {boolean} Returns `true` if the values are equivalent, else `false`.
     */
    function baseIsEqual$2(value, other, bitmask, customizer, stack) {
      if (value === other) {
        return true;
      }
      if (value == null || other == null || (!isObjectLike$2(value) && !isObjectLike$2(other))) {
        return value !== value && other !== other;
      }
      return baseIsEqualDeep(value, other, bitmask, customizer, baseIsEqual$2, stack);
    }

    var _baseIsEqual = baseIsEqual$2;

    var Stack = _Stack,
        baseIsEqual$1 = _baseIsEqual;

    /** Used to compose bitmasks for value comparisons. */
    var COMPARE_PARTIAL_FLAG$1 = 1,
        COMPARE_UNORDERED_FLAG$1 = 2;

    /**
     * The base implementation of `_.isMatch` without support for iteratee shorthands.
     *
     * @private
     * @param {Object} object The object to inspect.
     * @param {Object} source The object of property values to match.
     * @param {Array} matchData The property names, values, and compare flags to match.
     * @param {Function} [customizer] The function to customize comparisons.
     * @returns {boolean} Returns `true` if `object` is a match, else `false`.
     */
    function baseIsMatch$1(object, source, matchData, customizer) {
      var index = matchData.length,
          length = index,
          noCustomizer = !customizer;

      if (object == null) {
        return !length;
      }
      object = Object(object);
      while (index--) {
        var data = matchData[index];
        if ((noCustomizer && data[2])
              ? data[1] !== object[data[0]]
              : !(data[0] in object)
            ) {
          return false;
        }
      }
      while (++index < length) {
        data = matchData[index];
        var key = data[0],
            objValue = object[key],
            srcValue = data[1];

        if (noCustomizer && data[2]) {
          if (objValue === undefined && !(key in object)) {
            return false;
          }
        } else {
          var stack = new Stack;
          if (customizer) {
            var result = customizer(objValue, srcValue, key, object, source, stack);
          }
          if (!(result === undefined
                ? baseIsEqual$1(srcValue, objValue, COMPARE_PARTIAL_FLAG$1 | COMPARE_UNORDERED_FLAG$1, customizer, stack)
                : result
              )) {
            return false;
          }
        }
      }
      return true;
    }

    var _baseIsMatch = baseIsMatch$1;

    var isObject$2 = isObject_1;

    /**
     * Checks if `value` is suitable for strict equality comparisons, i.e. `===`.
     *
     * @private
     * @param {*} value The value to check.
     * @returns {boolean} Returns `true` if `value` if suitable for strict
     *  equality comparisons, else `false`.
     */
    function isStrictComparable$2(value) {
      return value === value && !isObject$2(value);
    }

    var _isStrictComparable = isStrictComparable$2;

    var isStrictComparable$1 = _isStrictComparable,
        keys$1 = keys_1;

    /**
     * Gets the property names, values, and compare flags of `object`.
     *
     * @private
     * @param {Object} object The object to query.
     * @returns {Array} Returns the match data of `object`.
     */
    function getMatchData$1(object) {
      var result = keys$1(object),
          length = result.length;

      while (length--) {
        var key = result[length],
            value = object[key];

        result[length] = [key, value, isStrictComparable$1(value)];
      }
      return result;
    }

    var _getMatchData = getMatchData$1;

    /**
     * A specialized version of `matchesProperty` for source values suitable
     * for strict equality comparisons, i.e. `===`.
     *
     * @private
     * @param {string} key The key of the property to get.
     * @param {*} srcValue The value to match.
     * @returns {Function} Returns the new spec function.
     */

    function matchesStrictComparable$2(key, srcValue) {
      return function(object) {
        if (object == null) {
          return false;
        }
        return object[key] === srcValue &&
          (srcValue !== undefined || (key in Object(object)));
      };
    }

    var _matchesStrictComparable = matchesStrictComparable$2;

    var baseIsMatch = _baseIsMatch,
        getMatchData = _getMatchData,
        matchesStrictComparable$1 = _matchesStrictComparable;

    /**
     * The base implementation of `_.matches` which doesn't clone `source`.
     *
     * @private
     * @param {Object} source The object of property values to match.
     * @returns {Function} Returns the new spec function.
     */
    function baseMatches$1(source) {
      var matchData = getMatchData(source);
      if (matchData.length == 1 && matchData[0][2]) {
        return matchesStrictComparable$1(matchData[0][0], matchData[0][1]);
      }
      return function(object) {
        return object === source || baseIsMatch(object, source, matchData);
      };
    }

    var _baseMatches = baseMatches$1;

    /**
     * The base implementation of `_.hasIn` without support for deep paths.
     *
     * @private
     * @param {Object} [object] The object to query.
     * @param {Array|string} key The key to check.
     * @returns {boolean} Returns `true` if `key` exists, else `false`.
     */

    function baseHasIn$1(object, key) {
      return object != null && key in Object(object);
    }

    var _baseHasIn = baseHasIn$1;

    var castPath$1 = _castPath,
        isArguments$2 = isArguments_1,
        isArray$7 = isArray_1,
        isIndex$1 = _isIndex,
        isLength = isLength_1,
        toKey$3 = _toKey;

    /**
     * Checks if `path` exists on `object`.
     *
     * @private
     * @param {Object} object The object to query.
     * @param {Array|string} path The path to check.
     * @param {Function} hasFunc The function to check properties.
     * @returns {boolean} Returns `true` if `path` exists, else `false`.
     */
    function hasPath$2(object, path, hasFunc) {
      path = castPath$1(path, object);

      var index = -1,
          length = path.length,
          result = false;

      while (++index < length) {
        var key = toKey$3(path[index]);
        if (!(result = object != null && hasFunc(object, key))) {
          break;
        }
        object = object[key];
      }
      if (result || ++index != length) {
        return result;
      }
      length = object == null ? 0 : object.length;
      return !!length && isLength(length) && isIndex$1(key, length) &&
        (isArray$7(object) || isArguments$2(object));
    }

    var _hasPath = hasPath$2;

    var baseHasIn = _baseHasIn,
        hasPath$1 = _hasPath;

    /**
     * Checks if `path` is a direct or inherited property of `object`.
     *
     * @static
     * @memberOf _
     * @since 4.0.0
     * @category Object
     * @param {Object} object The object to query.
     * @param {Array|string} path The path to check.
     * @returns {boolean} Returns `true` if `path` exists, else `false`.
     * @example
     *
     * var object = _.create({ 'a': _.create({ 'b': 2 }) });
     *
     * _.hasIn(object, 'a');
     * // => true
     *
     * _.hasIn(object, 'a.b');
     * // => true
     *
     * _.hasIn(object, ['a', 'b']);
     * // => true
     *
     * _.hasIn(object, 'b');
     * // => false
     */
    function hasIn$1(object, path) {
      return object != null && hasPath$1(object, path, baseHasIn);
    }

    var hasIn_1 = hasIn$1;

    var baseIsEqual = _baseIsEqual,
        get = get_1,
        hasIn = hasIn_1,
        isKey$1 = _isKey,
        isStrictComparable = _isStrictComparable,
        matchesStrictComparable = _matchesStrictComparable,
        toKey$2 = _toKey;

    /** Used to compose bitmasks for value comparisons. */
    var COMPARE_PARTIAL_FLAG = 1,
        COMPARE_UNORDERED_FLAG = 2;

    /**
     * The base implementation of `_.matchesProperty` which doesn't clone `srcValue`.
     *
     * @private
     * @param {string} path The path of the property to get.
     * @param {*} srcValue The value to match.
     * @returns {Function} Returns the new spec function.
     */
    function baseMatchesProperty$1(path, srcValue) {
      if (isKey$1(path) && isStrictComparable(srcValue)) {
        return matchesStrictComparable(toKey$2(path), srcValue);
      }
      return function(object) {
        var objValue = get(object, path);
        return (objValue === undefined && objValue === srcValue)
          ? hasIn(object, path)
          : baseIsEqual(srcValue, objValue, COMPARE_PARTIAL_FLAG | COMPARE_UNORDERED_FLAG);
      };
    }

    var _baseMatchesProperty = baseMatchesProperty$1;

    /**
     * This method returns the first argument it receives.
     *
     * @static
     * @since 0.1.0
     * @memberOf _
     * @category Util
     * @param {*} value Any value.
     * @returns {*} Returns `value`.
     * @example
     *
     * var object = { 'a': 1 };
     *
     * console.log(_.identity(object) === object);
     * // => true
     */

    function identity$5(value) {
      return value;
    }

    var identity_1 = identity$5;

    /**
     * The base implementation of `_.property` without support for deep paths.
     *
     * @private
     * @param {string} key The key of the property to get.
     * @returns {Function} Returns the new accessor function.
     */

    function baseProperty$2(key) {
      return function(object) {
        return object == null ? undefined : object[key];
      };
    }

    var _baseProperty = baseProperty$2;

    var baseGet$2 = _baseGet;

    /**
     * A specialized version of `baseProperty` which supports deep paths.
     *
     * @private
     * @param {Array|string} path The path of the property to get.
     * @returns {Function} Returns the new accessor function.
     */
    function basePropertyDeep$1(path) {
      return function(object) {
        return baseGet$2(object, path);
      };
    }

    var _basePropertyDeep = basePropertyDeep$1;

    var baseProperty$1 = _baseProperty,
        basePropertyDeep = _basePropertyDeep,
        isKey = _isKey,
        toKey$1 = _toKey;

    /**
     * Creates a function that returns the value at `path` of a given object.
     *
     * @static
     * @memberOf _
     * @since 2.4.0
     * @category Util
     * @param {Array|string} path The path of the property to get.
     * @returns {Function} Returns the new accessor function.
     * @example
     *
     * var objects = [
     *   { 'a': { 'b': 2 } },
     *   { 'a': { 'b': 1 } }
     * ];
     *
     * _.map(objects, _.property('a.b'));
     * // => [2, 1]
     *
     * _.map(_.sortBy(objects, _.property(['a', 'b'])), 'a.b');
     * // => [1, 2]
     */
    function property$1(path) {
      return isKey(path) ? baseProperty$1(toKey$1(path)) : basePropertyDeep(path);
    }

    var property_1 = property$1;

    var baseMatches = _baseMatches,
        baseMatchesProperty = _baseMatchesProperty,
        identity$4 = identity_1,
        isArray$6 = isArray_1,
        property = property_1;

    /**
     * The base implementation of `_.iteratee`.
     *
     * @private
     * @param {*} [value=_.identity] The value to convert to an iteratee.
     * @returns {Function} Returns the iteratee.
     */
    function baseIteratee$2(value) {
      // Don't store the `typeof` result in a variable to avoid a JIT bug in Safari 9.
      // See https://bugs.webkit.org/show_bug.cgi?id=156034 for more details.
      if (typeof value == 'function') {
        return value;
      }
      if (value == null) {
        return identity$4;
      }
      if (typeof value == 'object') {
        return isArray$6(value)
          ? baseMatchesProperty(value[0], value[1])
          : baseMatches(value);
      }
      return property(value);
    }

    var _baseIteratee = baseIteratee$2;

    /**
     * Gets the last element of `array`.
     *
     * @static
     * @memberOf _
     * @since 0.1.0
     * @category Array
     * @param {Array} array The array to query.
     * @returns {*} Returns the last element of `array`.
     * @example
     *
     * _.last([1, 2, 3]);
     * // => 3
     */

    function last$1(array) {
      var length = array == null ? 0 : array.length;
      return length ? array[length - 1] : undefined;
    }

    var last_1 = last$1;

    var baseGet$1 = _baseGet,
        baseSlice$2 = _baseSlice;

    /**
     * Gets the parent value at `path` of `object`.
     *
     * @private
     * @param {Object} object The object to query.
     * @param {Array} path The path to get the parent value of.
     * @returns {*} Returns the parent value.
     */
    function parent$1(object, path) {
      return path.length < 2 ? object : baseGet$1(object, baseSlice$2(path, 0, -1));
    }

    var _parent = parent$1;

    var castPath = _castPath,
        last = last_1,
        parent = _parent,
        toKey = _toKey;

    /**
     * The base implementation of `_.unset`.
     *
     * @private
     * @param {Object} object The object to modify.
     * @param {Array|string} path The property path to unset.
     * @returns {boolean} Returns `true` if the property is deleted, else `false`.
     */
    function baseUnset$1(object, path) {
      path = castPath(path, object);
      object = parent(object, path);
      return object == null || delete object[toKey(last(path))];
    }

    var _baseUnset = baseUnset$1;

    var baseUnset = _baseUnset,
        isIndex = _isIndex;

    /** Used for built-in method references. */
    var arrayProto$1 = Array.prototype;

    /** Built-in value references. */
    var splice = arrayProto$1.splice;

    /**
     * The base implementation of `_.pullAt` without support for individual
     * indexes or capturing the removed elements.
     *
     * @private
     * @param {Array} array The array to modify.
     * @param {number[]} indexes The indexes of elements to remove.
     * @returns {Array} Returns `array`.
     */
    function basePullAt$1(array, indexes) {
      var length = array ? indexes.length : 0,
          lastIndex = length - 1;

      while (length--) {
        var index = indexes[length];
        if (length == lastIndex || index !== previous) {
          var previous = index;
          if (isIndex(index)) {
            splice.call(array, index, 1);
          } else {
            baseUnset(array, index);
          }
        }
      }
      return array;
    }

    var _basePullAt = basePullAt$1;

    var baseIteratee$1 = _baseIteratee,
        basePullAt = _basePullAt;

    /**
     * Removes all elements from `array` that `predicate` returns truthy for
     * and returns an array of the removed elements. The predicate is invoked
     * with three arguments: (value, index, array).
     *
     * **Note:** Unlike `_.filter`, this method mutates `array`. Use `_.pull`
     * to pull elements from an array by value.
     *
     * @static
     * @memberOf _
     * @since 2.0.0
     * @category Array
     * @param {Array} array The array to modify.
     * @param {Function} [predicate=_.identity] The function invoked per iteration.
     * @returns {Array} Returns the new array of removed elements.
     * @example
     *
     * var array = [1, 2, 3, 4];
     * var evens = _.remove(array, function(n) {
     *   return n % 2 == 0;
     * });
     *
     * console.log(array);
     * // => [1, 3]
     *
     * console.log(evens);
     * // => [2, 4]
     */
    function remove(array, predicate) {
      var result = [];
      if (!(array && array.length)) {
        return result;
      }
      var index = -1,
          indexes = [],
          length = array.length;

      predicate = baseIteratee$1(predicate);
      while (++index < length) {
        var value = array[index];
        if (predicate(value, index, array)) {
          result.push(value);
          indexes.push(index);
        }
      }
      basePullAt(array, indexes);
      return result;
    }

    var remove_1 = remove;

    var baseSlice$1 = _baseSlice,
        toInteger$1 = toInteger_1;

    /**
     * Creates a slice of `array` with `n` elements taken from the beginning.
     *
     * @static
     * @memberOf _
     * @since 0.1.0
     * @category Array
     * @param {Array} array The array to query.
     * @param {number} [n=1] The number of elements to take.
     * @param- {Object} [guard] Enables use as an iteratee for methods like `_.map`.
     * @returns {Array} Returns the slice of `array`.
     * @example
     *
     * _.take([1, 2, 3]);
     * // => [1]
     *
     * _.take([1, 2, 3], 2);
     * // => [1, 2]
     *
     * _.take([1, 2, 3], 5);
     * // => [1, 2, 3]
     *
     * _.take([1, 2, 3], 0);
     * // => []
     */
    function take(array, n, guard) {
      if (!(array && array.length)) {
        return [];
      }
      n = (guard || n === undefined) ? 1 : toInteger$1(n);
      return baseSlice$1(array, 0, n < 0 ? 0 : n);
    }

    var take_1 = take;

    var baseGetTag$1 = _baseGetTag,
        isArray$5 = isArray_1,
        isObjectLike$1 = isObjectLike_1;

    /** `Object#toString` result references. */
    var stringTag = '[object String]';

    /**
     * Checks if `value` is classified as a `String` primitive or object.
     *
     * @static
     * @since 0.1.0
     * @memberOf _
     * @category Lang
     * @param {*} value The value to check.
     * @returns {boolean} Returns `true` if `value` is a string, else `false`.
     * @example
     *
     * _.isString('abc');
     * // => true
     *
     * _.isString(1);
     * // => false
     */
    function isString$1(value) {
      return typeof value == 'string' ||
        (!isArray$5(value) && isObjectLike$1(value) && baseGetTag$1(value) == stringTag);
    }

    var isString_1 = isString$1;

    var baseProperty = _baseProperty;

    /**
     * Gets the size of an ASCII `string`.
     *
     * @private
     * @param {string} string The string inspect.
     * @returns {number} Returns the string size.
     */
    var asciiSize$1 = baseProperty('length');

    var _asciiSize = asciiSize$1;

    /** Used to compose unicode character classes. */

    var rsAstralRange$2 = '\\ud800-\\udfff',
        rsComboMarksRange$2 = '\\u0300-\\u036f',
        reComboHalfMarksRange$2 = '\\ufe20-\\ufe2f',
        rsComboSymbolsRange$2 = '\\u20d0-\\u20ff',
        rsComboRange$2 = rsComboMarksRange$2 + reComboHalfMarksRange$2 + rsComboSymbolsRange$2,
        rsVarRange$2 = '\\ufe0e\\ufe0f';

    /** Used to compose unicode capture groups. */
    var rsZWJ$2 = '\\u200d';

    /** Used to detect strings with [zero-width joiners or code points from the astral planes](http://eev.ee/blog/2015/09/12/dark-corners-of-unicode/). */
    var reHasUnicode = RegExp('[' + rsZWJ$2 + rsAstralRange$2  + rsComboRange$2 + rsVarRange$2 + ']');

    /**
     * Checks if `string` contains Unicode symbols.
     *
     * @private
     * @param {string} string The string to inspect.
     * @returns {boolean} Returns `true` if a symbol is found, else `false`.
     */
    function hasUnicode$3(string) {
      return reHasUnicode.test(string);
    }

    var _hasUnicode = hasUnicode$3;

    /** Used to compose unicode character classes. */

    var rsAstralRange$1 = '\\ud800-\\udfff',
        rsComboMarksRange$1 = '\\u0300-\\u036f',
        reComboHalfMarksRange$1 = '\\ufe20-\\ufe2f',
        rsComboSymbolsRange$1 = '\\u20d0-\\u20ff',
        rsComboRange$1 = rsComboMarksRange$1 + reComboHalfMarksRange$1 + rsComboSymbolsRange$1,
        rsVarRange$1 = '\\ufe0e\\ufe0f';

    /** Used to compose unicode capture groups. */
    var rsAstral$1 = '[' + rsAstralRange$1 + ']',
        rsCombo$1 = '[' + rsComboRange$1 + ']',
        rsFitz$1 = '\\ud83c[\\udffb-\\udfff]',
        rsModifier$1 = '(?:' + rsCombo$1 + '|' + rsFitz$1 + ')',
        rsNonAstral$1 = '[^' + rsAstralRange$1 + ']',
        rsRegional$1 = '(?:\\ud83c[\\udde6-\\uddff]){2}',
        rsSurrPair$1 = '[\\ud800-\\udbff][\\udc00-\\udfff]',
        rsZWJ$1 = '\\u200d';

    /** Used to compose unicode regexes. */
    var reOptMod$1 = rsModifier$1 + '?',
        rsOptVar$1 = '[' + rsVarRange$1 + ']?',
        rsOptJoin$1 = '(?:' + rsZWJ$1 + '(?:' + [rsNonAstral$1, rsRegional$1, rsSurrPair$1].join('|') + ')' + rsOptVar$1 + reOptMod$1 + ')*',
        rsSeq$1 = rsOptVar$1 + reOptMod$1 + rsOptJoin$1,
        rsSymbol$1 = '(?:' + [rsNonAstral$1 + rsCombo$1 + '?', rsCombo$1, rsRegional$1, rsSurrPair$1, rsAstral$1].join('|') + ')';

    /** Used to match [string symbols](https://mathiasbynens.be/notes/javascript-unicode). */
    var reUnicode$1 = RegExp(rsFitz$1 + '(?=' + rsFitz$1 + ')|' + rsSymbol$1 + rsSeq$1, 'g');

    /**
     * Gets the size of a Unicode `string`.
     *
     * @private
     * @param {string} string The string inspect.
     * @returns {number} Returns the string size.
     */
    function unicodeSize$1(string) {
      var result = reUnicode$1.lastIndex = 0;
      while (reUnicode$1.test(string)) {
        ++result;
      }
      return result;
    }

    var _unicodeSize = unicodeSize$1;

    var asciiSize = _asciiSize,
        hasUnicode$2 = _hasUnicode,
        unicodeSize = _unicodeSize;

    /**
     * Gets the number of symbols in `string`.
     *
     * @private
     * @param {string} string The string to inspect.
     * @returns {number} Returns the string size.
     */
    function stringSize$2(string) {
      return hasUnicode$2(string)
        ? unicodeSize(string)
        : asciiSize(string);
    }

    var _stringSize = stringSize$2;

    var baseKeys$1 = _baseKeys,
        getTag$1 = _getTag,
        isArrayLike$3 = isArrayLike_1,
        isString = isString_1,
        stringSize$1 = _stringSize;

    /** `Object#toString` result references. */
    var mapTag$1 = '[object Map]',
        setTag$1 = '[object Set]';

    /**
     * Gets the size of `collection` by returning its length for array-like
     * values or the number of own enumerable string keyed properties for objects.
     *
     * @static
     * @memberOf _
     * @since 0.1.0
     * @category Collection
     * @param {Array|Object|string} collection The collection to inspect.
     * @returns {number} Returns the collection size.
     * @example
     *
     * _.size([1, 2, 3]);
     * // => 3
     *
     * _.size({ 'a': 1, 'b': 2 });
     * // => 2
     *
     * _.size('pebbles');
     * // => 7
     */
    function size(collection) {
      if (collection == null) {
        return 0;
      }
      if (isArrayLike$3(collection)) {
        return isString(collection) ? stringSize$1(collection) : collection.length;
      }
      var tag = getTag$1(collection);
      if (tag == mapTag$1 || tag == setTag$1) {
        return collection.size;
      }
      return baseKeys$1(collection).length;
    }

    var size_1 = size;

    var toString$2 = toString_1;

    /** Used to generate unique IDs. */
    var idCounter = 0;

    /**
     * Generates a unique ID. If `prefix` is given, the ID is appended to it.
     *
     * @static
     * @since 0.1.0
     * @memberOf _
     * @category Util
     * @param {string} [prefix=''] The value to prefix the ID with.
     * @returns {string} Returns the unique ID.
     * @example
     *
     * _.uniqueId('contact_');
     * // => 'contact_104'
     *
     * _.uniqueId();
     * // => '105'
     */
    function uniqueId(prefix) {
      var id = ++idCounter;
      return toString$2(prefix) + id;
    }

    var uniqueId_1 = uniqueId;

    var Symbol$1 = _Symbol,
        isArguments$1 = isArguments_1,
        isArray$4 = isArray_1;

    /** Built-in value references. */
    var spreadableSymbol = Symbol$1 ? Symbol$1.isConcatSpreadable : undefined;

    /**
     * Checks if `value` is a flattenable `arguments` object or array.
     *
     * @private
     * @param {*} value The value to check.
     * @returns {boolean} Returns `true` if `value` is flattenable, else `false`.
     */
    function isFlattenable$1(value) {
      return isArray$4(value) || isArguments$1(value) ||
        !!(spreadableSymbol && value && value[spreadableSymbol]);
    }

    var _isFlattenable = isFlattenable$1;

    var arrayPush = _arrayPush,
        isFlattenable = _isFlattenable;

    /**
     * The base implementation of `_.flatten` with support for restricting flattening.
     *
     * @private
     * @param {Array} array The array to flatten.
     * @param {number} depth The maximum recursion depth.
     * @param {boolean} [predicate=isFlattenable] The function invoked per iteration.
     * @param {boolean} [isStrict] Restrict to values that pass `predicate` checks.
     * @param {Array} [result=[]] The initial result value.
     * @returns {Array} Returns the new flattened array.
     */
    function baseFlatten$1(array, depth, predicate, isStrict, result) {
      var index = -1,
          length = array.length;

      predicate || (predicate = isFlattenable);
      result || (result = []);

      while (++index < length) {
        var value = array[index];
        if (depth > 0 && predicate(value)) {
          if (depth > 1) {
            // Recursively flatten arrays (susceptible to call stack limits).
            baseFlatten$1(value, depth - 1, predicate, isStrict, result);
          } else {
            arrayPush(result, value);
          }
        } else if (!isStrict) {
          result[result.length] = value;
        }
      }
      return result;
    }

    var _baseFlatten = baseFlatten$1;

    /**
     * Creates a base function for methods like `_.forIn` and `_.forOwn`.
     *
     * @private
     * @param {boolean} [fromRight] Specify iterating from right to left.
     * @returns {Function} Returns the new base function.
     */

    function createBaseFor$1(fromRight) {
      return function(object, iteratee, keysFunc) {
        var index = -1,
            iterable = Object(object),
            props = keysFunc(object),
            length = props.length;

        while (length--) {
          var key = props[fromRight ? length : ++index];
          if (iteratee(iterable[key], key, iterable) === false) {
            break;
          }
        }
        return object;
      };
    }

    var _createBaseFor = createBaseFor$1;

    var createBaseFor = _createBaseFor;

    /**
     * The base implementation of `baseForOwn` which iterates over `object`
     * properties returned by `keysFunc` and invokes `iteratee` for each property.
     * Iteratee functions may exit iteration early by explicitly returning `false`.
     *
     * @private
     * @param {Object} object The object to iterate over.
     * @param {Function} iteratee The function invoked per iteration.
     * @param {Function} keysFunc The function to get the keys of `object`.
     * @returns {Object} Returns `object`.
     */
    var baseFor$1 = createBaseFor();

    var _baseFor = baseFor$1;

    var baseFor = _baseFor,
        keys = keys_1;

    /**
     * The base implementation of `_.forOwn` without support for iteratee shorthands.
     *
     * @private
     * @param {Object} object The object to iterate over.
     * @param {Function} iteratee The function invoked per iteration.
     * @returns {Object} Returns `object`.
     */
    function baseForOwn$1(object, iteratee) {
      return object && baseFor(object, iteratee, keys);
    }

    var _baseForOwn = baseForOwn$1;

    var isArrayLike$2 = isArrayLike_1;

    /**
     * Creates a `baseEach` or `baseEachRight` function.
     *
     * @private
     * @param {Function} eachFunc The function to iterate over a collection.
     * @param {boolean} [fromRight] Specify iterating from right to left.
     * @returns {Function} Returns the new base function.
     */
    function createBaseEach$1(eachFunc, fromRight) {
      return function(collection, iteratee) {
        if (collection == null) {
          return collection;
        }
        if (!isArrayLike$2(collection)) {
          return eachFunc(collection, iteratee);
        }
        var length = collection.length,
            index = fromRight ? length : -1,
            iterable = Object(collection);

        while ((fromRight ? index-- : ++index < length)) {
          if (iteratee(iterable[index], index, iterable) === false) {
            break;
          }
        }
        return collection;
      };
    }

    var _createBaseEach = createBaseEach$1;

    var baseForOwn = _baseForOwn,
        createBaseEach = _createBaseEach;

    /**
     * The base implementation of `_.forEach` without support for iteratee shorthands.
     *
     * @private
     * @param {Array|Object} collection The collection to iterate over.
     * @param {Function} iteratee The function invoked per iteration.
     * @returns {Array|Object} Returns `collection`.
     */
    var baseEach$1 = createBaseEach(baseForOwn);

    var _baseEach = baseEach$1;

    var baseEach = _baseEach,
        isArrayLike$1 = isArrayLike_1;

    /**
     * The base implementation of `_.map` without support for iteratee shorthands.
     *
     * @private
     * @param {Array|Object} collection The collection to iterate over.
     * @param {Function} iteratee The function invoked per iteration.
     * @returns {Array} Returns the new mapped array.
     */
    function baseMap$1(collection, iteratee) {
      var index = -1,
          result = isArrayLike$1(collection) ? Array(collection.length) : [];

      baseEach(collection, function(value, key, collection) {
        result[++index] = iteratee(value, key, collection);
      });
      return result;
    }

    var _baseMap = baseMap$1;

    /**
     * The base implementation of `_.sortBy` which uses `comparer` to define the
     * sort order of `array` and replaces criteria objects with their corresponding
     * values.
     *
     * @private
     * @param {Array} array The array to sort.
     * @param {Function} comparer The function to define sort order.
     * @returns {Array} Returns `array`.
     */

    function baseSortBy$1(array, comparer) {
      var length = array.length;

      array.sort(comparer);
      while (length--) {
        array[length] = array[length].value;
      }
      return array;
    }

    var _baseSortBy = baseSortBy$1;

    var isSymbol = isSymbol_1;

    /**
     * Compares values to sort them in ascending order.
     *
     * @private
     * @param {*} value The value to compare.
     * @param {*} other The other value to compare.
     * @returns {number} Returns the sort order indicator for `value`.
     */
    function compareAscending$1(value, other) {
      if (value !== other) {
        var valIsDefined = value !== undefined,
            valIsNull = value === null,
            valIsReflexive = value === value,
            valIsSymbol = isSymbol(value);

        var othIsDefined = other !== undefined,
            othIsNull = other === null,
            othIsReflexive = other === other,
            othIsSymbol = isSymbol(other);

        if ((!othIsNull && !othIsSymbol && !valIsSymbol && value > other) ||
            (valIsSymbol && othIsDefined && othIsReflexive && !othIsNull && !othIsSymbol) ||
            (valIsNull && othIsDefined && othIsReflexive) ||
            (!valIsDefined && othIsReflexive) ||
            !valIsReflexive) {
          return 1;
        }
        if ((!valIsNull && !valIsSymbol && !othIsSymbol && value < other) ||
            (othIsSymbol && valIsDefined && valIsReflexive && !valIsNull && !valIsSymbol) ||
            (othIsNull && valIsDefined && valIsReflexive) ||
            (!othIsDefined && valIsReflexive) ||
            !othIsReflexive) {
          return -1;
        }
      }
      return 0;
    }

    var _compareAscending = compareAscending$1;

    var compareAscending = _compareAscending;

    /**
     * Used by `_.orderBy` to compare multiple properties of a value to another
     * and stable sort them.
     *
     * If `orders` is unspecified, all values are sorted in ascending order. Otherwise,
     * specify an order of "desc" for descending or "asc" for ascending sort order
     * of corresponding values.
     *
     * @private
     * @param {Object} object The object to compare.
     * @param {Object} other The other object to compare.
     * @param {boolean[]|string[]} orders The order to sort by for each property.
     * @returns {number} Returns the sort order indicator for `object`.
     */
    function compareMultiple$1(object, other, orders) {
      var index = -1,
          objCriteria = object.criteria,
          othCriteria = other.criteria,
          length = objCriteria.length,
          ordersLength = orders.length;

      while (++index < length) {
        var result = compareAscending(objCriteria[index], othCriteria[index]);
        if (result) {
          if (index >= ordersLength) {
            return result;
          }
          var order = orders[index];
          return result * (order == 'desc' ? -1 : 1);
        }
      }
      // Fixes an `Array#sort` bug in the JS engine embedded in Adobe applications
      // that causes it, under certain circumstances, to provide the same value for
      // `object` and `other`. See https://github.com/jashkenas/underscore/pull/1247
      // for more details.
      //
      // This also ensures a stable sort in V8 and other engines.
      // See https://bugs.chromium.org/p/v8/issues/detail?id=90 for more details.
      return object.index - other.index;
    }

    var _compareMultiple = compareMultiple$1;

    var arrayMap = _arrayMap,
        baseGet = _baseGet,
        baseIteratee = _baseIteratee,
        baseMap = _baseMap,
        baseSortBy = _baseSortBy,
        baseUnary$1 = _baseUnary,
        compareMultiple = _compareMultiple,
        identity$3 = identity_1,
        isArray$3 = isArray_1;

    /**
     * The base implementation of `_.orderBy` without param guards.
     *
     * @private
     * @param {Array|Object} collection The collection to iterate over.
     * @param {Function[]|Object[]|string[]} iteratees The iteratees to sort by.
     * @param {string[]} orders The sort orders of `iteratees`.
     * @returns {Array} Returns the new sorted array.
     */
    function baseOrderBy$1(collection, iteratees, orders) {
      if (iteratees.length) {
        iteratees = arrayMap(iteratees, function(iteratee) {
          if (isArray$3(iteratee)) {
            return function(value) {
              return baseGet(value, iteratee.length === 1 ? iteratee[0] : iteratee);
            }
          }
          return iteratee;
        });
      } else {
        iteratees = [identity$3];
      }

      var index = -1;
      iteratees = arrayMap(iteratees, baseUnary$1(baseIteratee));

      var result = baseMap(collection, function(value, key, collection) {
        var criteria = arrayMap(iteratees, function(iteratee) {
          return iteratee(value);
        });
        return { 'criteria': criteria, 'index': ++index, 'value': value };
      });

      return baseSortBy(result, function(object, other) {
        return compareMultiple(object, other, orders);
      });
    }

    var _baseOrderBy = baseOrderBy$1;

    /**
     * A faster alternative to `Function#apply`, this function invokes `func`
     * with the `this` binding of `thisArg` and the arguments of `args`.
     *
     * @private
     * @param {Function} func The function to invoke.
     * @param {*} thisArg The `this` binding of `func`.
     * @param {Array} args The arguments to invoke `func` with.
     * @returns {*} Returns the result of `func`.
     */

    function apply$1(func, thisArg, args) {
      switch (args.length) {
        case 0: return func.call(thisArg);
        case 1: return func.call(thisArg, args[0]);
        case 2: return func.call(thisArg, args[0], args[1]);
        case 3: return func.call(thisArg, args[0], args[1], args[2]);
      }
      return func.apply(thisArg, args);
    }

    var _apply = apply$1;

    var apply = _apply;

    /* Built-in method references for those with the same name as other `lodash` methods. */
    var nativeMax = Math.max;

    /**
     * A specialized version of `baseRest` which transforms the rest array.
     *
     * @private
     * @param {Function} func The function to apply a rest parameter to.
     * @param {number} [start=func.length-1] The start position of the rest parameter.
     * @param {Function} transform The rest array transform.
     * @returns {Function} Returns the new function.
     */
    function overRest$1(func, start, transform) {
      start = nativeMax(start === undefined ? (func.length - 1) : start, 0);
      return function() {
        var args = arguments,
            index = -1,
            length = nativeMax(args.length - start, 0),
            array = Array(length);

        while (++index < length) {
          array[index] = args[start + index];
        }
        index = -1;
        var otherArgs = Array(start + 1);
        while (++index < start) {
          otherArgs[index] = args[index];
        }
        otherArgs[start] = transform(array);
        return apply(func, this, otherArgs);
      };
    }

    var _overRest = overRest$1;

    /**
     * Creates a function that returns `value`.
     *
     * @static
     * @memberOf _
     * @since 2.4.0
     * @category Util
     * @param {*} value The value to return from the new function.
     * @returns {Function} Returns the new constant function.
     * @example
     *
     * var objects = _.times(2, _.constant({ 'a': 1 }));
     *
     * console.log(objects);
     * // => [{ 'a': 1 }, { 'a': 1 }]
     *
     * console.log(objects[0] === objects[1]);
     * // => true
     */

    function constant$1(value) {
      return function() {
        return value;
      };
    }

    var constant_1 = constant$1;

    var getNative = _getNative;

    var defineProperty$1 = (function() {
      try {
        var func = getNative(Object, 'defineProperty');
        func({}, '', {});
        return func;
      } catch (e) {}
    }());

    var _defineProperty = defineProperty$1;

    var constant = constant_1,
        defineProperty = _defineProperty,
        identity$2 = identity_1;

    /**
     * The base implementation of `setToString` without support for hot loop shorting.
     *
     * @private
     * @param {Function} func The function to modify.
     * @param {Function} string The `toString` result.
     * @returns {Function} Returns `func`.
     */
    var baseSetToString$1 = !defineProperty ? identity$2 : function(func, string) {
      return defineProperty(func, 'toString', {
        'configurable': true,
        'enumerable': false,
        'value': constant(string),
        'writable': true
      });
    };

    var _baseSetToString = baseSetToString$1;

    /** Used to detect hot functions by number of calls within a span of milliseconds. */

    var HOT_COUNT = 800,
        HOT_SPAN = 16;

    /* Built-in method references for those with the same name as other `lodash` methods. */
    var nativeNow = Date.now;

    /**
     * Creates a function that'll short out and invoke `identity` instead
     * of `func` when it's called `HOT_COUNT` or more times in `HOT_SPAN`
     * milliseconds.
     *
     * @private
     * @param {Function} func The function to restrict.
     * @returns {Function} Returns the new shortable function.
     */
    function shortOut$1(func) {
      var count = 0,
          lastCalled = 0;

      return function() {
        var stamp = nativeNow(),
            remaining = HOT_SPAN - (stamp - lastCalled);

        lastCalled = stamp;
        if (remaining > 0) {
          if (++count >= HOT_COUNT) {
            return arguments[0];
          }
        } else {
          count = 0;
        }
        return func.apply(undefined, arguments);
      };
    }

    var _shortOut = shortOut$1;

    var baseSetToString = _baseSetToString,
        shortOut = _shortOut;

    /**
     * Sets the `toString` method of `func` to return `string`.
     *
     * @private
     * @param {Function} func The function to modify.
     * @param {Function} string The `toString` result.
     * @returns {Function} Returns `func`.
     */
    var setToString$1 = shortOut(baseSetToString);

    var _setToString = setToString$1;

    var identity$1 = identity_1,
        overRest = _overRest,
        setToString = _setToString;

    /**
     * The base implementation of `_.rest` which doesn't validate or coerce arguments.
     *
     * @private
     * @param {Function} func The function to apply a rest parameter to.
     * @param {number} [start=func.length-1] The start position of the rest parameter.
     * @returns {Function} Returns the new function.
     */
    function baseRest$1(func, start) {
      return setToString(overRest(func, start, identity$1), func + '');
    }

    var _baseRest = baseRest$1;

    var baseFlatten = _baseFlatten,
        baseOrderBy = _baseOrderBy,
        baseRest = _baseRest,
        isIterateeCall = _isIterateeCall;

    /**
     * Creates an array of elements, sorted in ascending order by the results of
     * running each element in a collection thru each iteratee. This method
     * performs a stable sort, that is, it preserves the original sort order of
     * equal elements. The iteratees are invoked with one argument: (value).
     *
     * @static
     * @memberOf _
     * @since 0.1.0
     * @category Collection
     * @param {Array|Object} collection The collection to iterate over.
     * @param {...(Function|Function[])} [iteratees=[_.identity]]
     *  The iteratees to sort by.
     * @returns {Array} Returns the new sorted array.
     * @example
     *
     * var users = [
     *   { 'user': 'fred',   'age': 48 },
     *   { 'user': 'barney', 'age': 36 },
     *   { 'user': 'fred',   'age': 30 },
     *   { 'user': 'barney', 'age': 34 }
     * ];
     *
     * _.sortBy(users, [function(o) { return o.user; }]);
     * // => objects for [['barney', 36], ['barney', 34], ['fred', 48], ['fred', 30]]
     *
     * _.sortBy(users, ['user', 'age']);
     * // => objects for [['barney', 34], ['barney', 36], ['fred', 30], ['fred', 48]]
     */
    var sortBy = baseRest(function(collection, iteratees) {
      if (collection == null) {
        return [];
      }
      var length = iteratees.length;
      if (length > 1 && isIterateeCall(collection, iteratees[0], iteratees[1])) {
        iteratees = [];
      } else if (length > 2 && isIterateeCall(iteratees[0], iteratees[1], iteratees[2])) {
        iteratees = [iteratees[0]];
      }
      return baseOrderBy(collection, baseFlatten(iteratees, 1), []);
    });

    var sortBy_1 = sortBy;

    /** Used for built-in method references. */

    var arrayProto = Array.prototype;

    /* Built-in method references for those with the same name as other `lodash` methods. */
    var nativeReverse = arrayProto.reverse;

    /**
     * Reverses `array` so that the first element becomes the last, the second
     * element becomes the second to last, and so on.
     *
     * **Note:** This method mutates `array` and is based on
     * [`Array#reverse`](https://mdn.io/Array/reverse).
     *
     * @static
     * @memberOf _
     * @since 4.0.0
     * @category Array
     * @param {Array} array The array to modify.
     * @returns {Array} Returns `array`.
     * @example
     *
     * var array = [1, 2, 3];
     *
     * _.reverse(array);
     * // => [3, 2, 1]
     *
     * console.log(array);
     * // => [3, 2, 1]
     */
    function reverse(array) {
      return array == null ? array : nativeReverse.call(array);
    }

    var reverse_1 = reverse;

    var baseKeys = _baseKeys,
        getTag = _getTag,
        isArguments = isArguments_1,
        isArray$2 = isArray_1,
        isArrayLike = isArrayLike_1,
        isBuffer$1 = isBufferExports,
        isPrototype = _isPrototype,
        isTypedArray = isTypedArray_1;

    /** `Object#toString` result references. */
    var mapTag = '[object Map]',
        setTag = '[object Set]';

    /** Used for built-in method references. */
    var objectProto$1 = Object.prototype;

    /** Used to check objects for own properties. */
    var hasOwnProperty$2 = objectProto$1.hasOwnProperty;

    /**
     * Checks if `value` is an empty object, collection, map, or set.
     *
     * Objects are considered empty if they have no own enumerable string keyed
     * properties.
     *
     * Array-like values such as `arguments` objects, arrays, buffers, strings, or
     * jQuery-like collections are considered empty if they have a `length` of `0`.
     * Similarly, maps and sets are considered empty if they have a `size` of `0`.
     *
     * @static
     * @memberOf _
     * @since 0.1.0
     * @category Lang
     * @param {*} value The value to check.
     * @returns {boolean} Returns `true` if `value` is empty, else `false`.
     * @example
     *
     * _.isEmpty(null);
     * // => true
     *
     * _.isEmpty(true);
     * // => true
     *
     * _.isEmpty(1);
     * // => true
     *
     * _.isEmpty([1, 2, 3]);
     * // => false
     *
     * _.isEmpty({ 'a': 1 });
     * // => false
     */
    function isEmpty(value) {
      if (value == null) {
        return true;
      }
      if (isArrayLike(value) &&
          (isArray$2(value) || typeof value == 'string' || typeof value.splice == 'function' ||
            isBuffer$1(value) || isTypedArray(value) || isArguments(value))) {
        return !value.length;
      }
      var tag = getTag(value);
      if (tag == mapTag || tag == setTag) {
        return !value.size;
      }
      if (isPrototype(value)) {
        return !baseKeys(value).length;
      }
      for (var key in value) {
        if (hasOwnProperty$2.call(value, key)) {
          return false;
        }
      }
      return true;
    }

    var isEmpty_1 = isEmpty;

    var lodash_minExports = {};
    var lodash_min = {
      get exports(){ return lodash_minExports; },
      set exports(v){ lodash_minExports = v; },
    };

    /**
     * @license
     * Lodash <https://lodash.com/>
     * Copyright OpenJS Foundation and other contributors <https://openjsf.org/>
     * Released under MIT license <https://lodash.com/license>
     * Based on Underscore.js 1.8.3 <http://underscorejs.org/LICENSE>
     * Copyright Jeremy Ashkenas, DocumentCloud and Investigative Reporters & Editors
     */

    (function (module, exports) {
    	(function(){function n(n,t,r){switch(r.length){case 0:return n.call(t);case 1:return n.call(t,r[0]);case 2:return n.call(t,r[0],r[1]);case 3:return n.call(t,r[0],r[1],r[2])}return n.apply(t,r)}function t(n,t,r,e){for(var u=-1,i=null==n?0:n.length;++u<i;){var o=n[u];t(e,o,r(o),n);}return e}function r(n,t){for(var r=-1,e=null==n?0:n.length;++r<e&&t(n[r],r,n)!==!1;);return n}function e(n,t){for(var r=null==n?0:n.length;r--&&t(n[r],r,n)!==!1;);return n}function u(n,t){for(var r=-1,e=null==n?0:n.length;++r<e;)if(!t(n[r],r,n))return !1;
    	return !0}function i(n,t){for(var r=-1,e=null==n?0:n.length,u=0,i=[];++r<e;){var o=n[r];t(o,r,n)&&(i[u++]=o);}return i}function o(n,t){return !!(null==n?0:n.length)&&y(n,t,0)>-1}function f(n,t,r){for(var e=-1,u=null==n?0:n.length;++e<u;)if(r(t,n[e]))return !0;return !1}function c(n,t){for(var r=-1,e=null==n?0:n.length,u=Array(e);++r<e;)u[r]=t(n[r],r,n);return u}function a(n,t){for(var r=-1,e=t.length,u=n.length;++r<e;)n[u+r]=t[r];return n}function l(n,t,r,e){var u=-1,i=null==n?0:n.length;for(e&&i&&(r=n[++u]);++u<i;)r=t(r,n[u],u,n);
    	return r}function s(n,t,r,e){var u=null==n?0:n.length;for(e&&u&&(r=n[--u]);u--;)r=t(r,n[u],u,n);return r}function h(n,t){for(var r=-1,e=null==n?0:n.length;++r<e;)if(t(n[r],r,n))return !0;return !1}function p(n){return n.split("")}function _(n){return n.match($t)||[]}function v(n,t,r){var e;return r(n,function(n,r,u){if(t(n,r,u))return e=r,!1}),e}function g(n,t,r,e){for(var u=n.length,i=r+(e?1:-1);e?i--:++i<u;)if(t(n[i],i,n))return i;return -1}function y(n,t,r){return t===t?Z(n,t,r):g(n,b,r)}function d(n,t,r,e){
    	for(var u=r-1,i=n.length;++u<i;)if(e(n[u],t))return u;return -1}function b(n){return n!==n}function w(n,t){var r=null==n?0:n.length;return r?k(n,t)/r:Cn}function m(n){return function(t){return null==t?X:t[n]}}function x(n){return function(t){return null==n?X:n[t]}}function j(n,t,r,e,u){return u(n,function(n,u,i){r=e?(e=!1,n):t(r,n,u,i);}),r}function A(n,t){var r=n.length;for(n.sort(t);r--;)n[r]=n[r].value;return n}function k(n,t){for(var r,e=-1,u=n.length;++e<u;){var i=t(n[e]);i!==X&&(r=r===X?i:r+i);
    	}return r}function O(n,t){for(var r=-1,e=Array(n);++r<n;)e[r]=t(r);return e}function I(n,t){return c(t,function(t){return [t,n[t]]})}function R(n){return n?n.slice(0,H(n)+1).replace(Lt,""):n}function z(n){return function(t){return n(t)}}function E(n,t){return c(t,function(t){return n[t]})}function S(n,t){return n.has(t)}function W(n,t){for(var r=-1,e=n.length;++r<e&&y(t,n[r],0)>-1;);return r}function L(n,t){for(var r=n.length;r--&&y(t,n[r],0)>-1;);return r}function C(n,t){for(var r=n.length,e=0;r--;)n[r]===t&&++e;
    	return e}function U(n){return "\\"+Yr[n]}function B(n,t){return null==n?X:n[t]}function T(n){return Nr.test(n)}function $(n){return Pr.test(n)}function D(n){for(var t,r=[];!(t=n.next()).done;)r.push(t.value);return r}function M(n){var t=-1,r=Array(n.size);return n.forEach(function(n,e){r[++t]=[e,n];}),r}function F(n,t){return function(r){return n(t(r))}}function N(n,t){for(var r=-1,e=n.length,u=0,i=[];++r<e;){var o=n[r];o!==t&&o!==cn||(n[r]=cn,i[u++]=r);}return i}function P(n){var t=-1,r=Array(n.size);
    	return n.forEach(function(n){r[++t]=n;}),r}function q(n){var t=-1,r=Array(n.size);return n.forEach(function(n){r[++t]=[n,n];}),r}function Z(n,t,r){for(var e=r-1,u=n.length;++e<u;)if(n[e]===t)return e;return -1}function K(n,t,r){for(var e=r+1;e--;)if(n[e]===t)return e;return e}function V(n){return T(n)?J(n):_e(n)}function G(n){return T(n)?Y(n):p(n)}function H(n){for(var t=n.length;t--&&Ct.test(n.charAt(t)););return t}function J(n){for(var t=Mr.lastIndex=0;Mr.test(n);)++t;return t}function Y(n){return n.match(Mr)||[];
    	}function Q(n){return n.match(Fr)||[]}var X,nn="4.17.21",tn=200,rn="Unsupported core-js use. Try https://npms.io/search?q=ponyfill.",en="Expected a function",un="Invalid `variable` option passed into `_.template`",on="__lodash_hash_undefined__",fn=500,cn="__lodash_placeholder__",an=1,ln=2,sn=4,hn=1,pn=2,_n=1,vn=2,gn=4,yn=8,dn=16,bn=32,wn=64,mn=128,xn=256,jn=512,An=30,kn="...",On=800,In=16,Rn=1,zn=2,En=3,Sn=1/0,Wn=9007199254740991,Ln=1.7976931348623157e308,Cn=NaN,Un=4294967295,Bn=Un-1,Tn=Un>>>1,$n=[["ary",mn],["bind",_n],["bindKey",vn],["curry",yn],["curryRight",dn],["flip",jn],["partial",bn],["partialRight",wn],["rearg",xn]],Dn="[object Arguments]",Mn="[object Array]",Fn="[object AsyncFunction]",Nn="[object Boolean]",Pn="[object Date]",qn="[object DOMException]",Zn="[object Error]",Kn="[object Function]",Vn="[object GeneratorFunction]",Gn="[object Map]",Hn="[object Number]",Jn="[object Null]",Yn="[object Object]",Qn="[object Promise]",Xn="[object Proxy]",nt="[object RegExp]",tt="[object Set]",rt="[object String]",et="[object Symbol]",ut="[object Undefined]",it="[object WeakMap]",ot="[object WeakSet]",ft="[object ArrayBuffer]",ct="[object DataView]",at="[object Float32Array]",lt="[object Float64Array]",st="[object Int8Array]",ht="[object Int16Array]",pt="[object Int32Array]",_t="[object Uint8Array]",vt="[object Uint8ClampedArray]",gt="[object Uint16Array]",yt="[object Uint32Array]",dt=/\b__p \+= '';/g,bt=/\b(__p \+=) '' \+/g,wt=/(__e\(.*?\)|\b__t\)) \+\n'';/g,mt=/&(?:amp|lt|gt|quot|#39);/g,xt=/[&<>"']/g,jt=RegExp(mt.source),At=RegExp(xt.source),kt=/<%-([\s\S]+?)%>/g,Ot=/<%([\s\S]+?)%>/g,It=/<%=([\s\S]+?)%>/g,Rt=/\.|\[(?:[^[\]]*|(["'])(?:(?!\1)[^\\]|\\.)*?\1)\]/,zt=/^\w*$/,Et=/[^.[\]]+|\[(?:(-?\d+(?:\.\d+)?)|(["'])((?:(?!\2)[^\\]|\\.)*?)\2)\]|(?=(?:\.|\[\])(?:\.|\[\]|$))/g,St=/[\\^$.*+?()[\]{}|]/g,Wt=RegExp(St.source),Lt=/^\s+/,Ct=/\s/,Ut=/\{(?:\n\/\* \[wrapped with .+\] \*\/)?\n?/,Bt=/\{\n\/\* \[wrapped with (.+)\] \*/,Tt=/,? & /,$t=/[^\x00-\x2f\x3a-\x40\x5b-\x60\x7b-\x7f]+/g,Dt=/[()=,{}\[\]\/\s]/,Mt=/\\(\\)?/g,Ft=/\$\{([^\\}]*(?:\\.[^\\}]*)*)\}/g,Nt=/\w*$/,Pt=/^[-+]0x[0-9a-f]+$/i,qt=/^0b[01]+$/i,Zt=/^\[object .+?Constructor\]$/,Kt=/^0o[0-7]+$/i,Vt=/^(?:0|[1-9]\d*)$/,Gt=/[\xc0-\xd6\xd8-\xf6\xf8-\xff\u0100-\u017f]/g,Ht=/($^)/,Jt=/['\n\r\u2028\u2029\\]/g,Yt="\\ud800-\\udfff",Qt="\\u0300-\\u036f",Xt="\\ufe20-\\ufe2f",nr="\\u20d0-\\u20ff",tr=Qt+Xt+nr,rr="\\u2700-\\u27bf",er="a-z\\xdf-\\xf6\\xf8-\\xff",ur="\\xac\\xb1\\xd7\\xf7",ir="\\x00-\\x2f\\x3a-\\x40\\x5b-\\x60\\x7b-\\xbf",or="\\u2000-\\u206f",fr=" \\t\\x0b\\f\\xa0\\ufeff\\n\\r\\u2028\\u2029\\u1680\\u180e\\u2000\\u2001\\u2002\\u2003\\u2004\\u2005\\u2006\\u2007\\u2008\\u2009\\u200a\\u202f\\u205f\\u3000",cr="A-Z\\xc0-\\xd6\\xd8-\\xde",ar="\\ufe0e\\ufe0f",lr=ur+ir+or+fr,sr="['\u2019]",hr="["+Yt+"]",pr="["+lr+"]",_r="["+tr+"]",vr="\\d+",gr="["+rr+"]",yr="["+er+"]",dr="[^"+Yt+lr+vr+rr+er+cr+"]",br="\\ud83c[\\udffb-\\udfff]",wr="(?:"+_r+"|"+br+")",mr="[^"+Yt+"]",xr="(?:\\ud83c[\\udde6-\\uddff]){2}",jr="[\\ud800-\\udbff][\\udc00-\\udfff]",Ar="["+cr+"]",kr="\\u200d",Or="(?:"+yr+"|"+dr+")",Ir="(?:"+Ar+"|"+dr+")",Rr="(?:"+sr+"(?:d|ll|m|re|s|t|ve))?",zr="(?:"+sr+"(?:D|LL|M|RE|S|T|VE))?",Er=wr+"?",Sr="["+ar+"]?",Wr="(?:"+kr+"(?:"+[mr,xr,jr].join("|")+")"+Sr+Er+")*",Lr="\\d*(?:1st|2nd|3rd|(?![123])\\dth)(?=\\b|[A-Z_])",Cr="\\d*(?:1ST|2ND|3RD|(?![123])\\dTH)(?=\\b|[a-z_])",Ur=Sr+Er+Wr,Br="(?:"+[gr,xr,jr].join("|")+")"+Ur,Tr="(?:"+[mr+_r+"?",_r,xr,jr,hr].join("|")+")",$r=RegExp(sr,"g"),Dr=RegExp(_r,"g"),Mr=RegExp(br+"(?="+br+")|"+Tr+Ur,"g"),Fr=RegExp([Ar+"?"+yr+"+"+Rr+"(?="+[pr,Ar,"$"].join("|")+")",Ir+"+"+zr+"(?="+[pr,Ar+Or,"$"].join("|")+")",Ar+"?"+Or+"+"+Rr,Ar+"+"+zr,Cr,Lr,vr,Br].join("|"),"g"),Nr=RegExp("["+kr+Yt+tr+ar+"]"),Pr=/[a-z][A-Z]|[A-Z]{2}[a-z]|[0-9][a-zA-Z]|[a-zA-Z][0-9]|[^a-zA-Z0-9 ]/,qr=["Array","Buffer","DataView","Date","Error","Float32Array","Float64Array","Function","Int8Array","Int16Array","Int32Array","Map","Math","Object","Promise","RegExp","Set","String","Symbol","TypeError","Uint8Array","Uint8ClampedArray","Uint16Array","Uint32Array","WeakMap","_","clearTimeout","isFinite","parseInt","setTimeout"],Zr=-1,Kr={};
    	Kr[at]=Kr[lt]=Kr[st]=Kr[ht]=Kr[pt]=Kr[_t]=Kr[vt]=Kr[gt]=Kr[yt]=!0,Kr[Dn]=Kr[Mn]=Kr[ft]=Kr[Nn]=Kr[ct]=Kr[Pn]=Kr[Zn]=Kr[Kn]=Kr[Gn]=Kr[Hn]=Kr[Yn]=Kr[nt]=Kr[tt]=Kr[rt]=Kr[it]=!1;var Vr={};Vr[Dn]=Vr[Mn]=Vr[ft]=Vr[ct]=Vr[Nn]=Vr[Pn]=Vr[at]=Vr[lt]=Vr[st]=Vr[ht]=Vr[pt]=Vr[Gn]=Vr[Hn]=Vr[Yn]=Vr[nt]=Vr[tt]=Vr[rt]=Vr[et]=Vr[_t]=Vr[vt]=Vr[gt]=Vr[yt]=!0,Vr[Zn]=Vr[Kn]=Vr[it]=!1;var Gr={"\xc0":"A","\xc1":"A","\xc2":"A","\xc3":"A","\xc4":"A","\xc5":"A","\xe0":"a","\xe1":"a","\xe2":"a","\xe3":"a","\xe4":"a","\xe5":"a",
    	"\xc7":"C","\xe7":"c","\xd0":"D","\xf0":"d","\xc8":"E","\xc9":"E","\xca":"E","\xcb":"E","\xe8":"e","\xe9":"e","\xea":"e","\xeb":"e","\xcc":"I","\xcd":"I","\xce":"I","\xcf":"I","\xec":"i","\xed":"i","\xee":"i","\xef":"i","\xd1":"N","\xf1":"n","\xd2":"O","\xd3":"O","\xd4":"O","\xd5":"O","\xd6":"O","\xd8":"O","\xf2":"o","\xf3":"o","\xf4":"o","\xf5":"o","\xf6":"o","\xf8":"o","\xd9":"U","\xda":"U","\xdb":"U","\xdc":"U","\xf9":"u","\xfa":"u","\xfb":"u","\xfc":"u","\xdd":"Y","\xfd":"y","\xff":"y","\xc6":"Ae",
    	"\xe6":"ae","\xde":"Th","\xfe":"th","\xdf":"ss","\u0100":"A","\u0102":"A","\u0104":"A","\u0101":"a","\u0103":"a","\u0105":"a","\u0106":"C","\u0108":"C","\u010a":"C","\u010c":"C","\u0107":"c","\u0109":"c","\u010b":"c","\u010d":"c","\u010e":"D","\u0110":"D","\u010f":"d","\u0111":"d","\u0112":"E","\u0114":"E","\u0116":"E","\u0118":"E","\u011a":"E","\u0113":"e","\u0115":"e","\u0117":"e","\u0119":"e","\u011b":"e","\u011c":"G","\u011e":"G","\u0120":"G","\u0122":"G","\u011d":"g","\u011f":"g","\u0121":"g",
    	"\u0123":"g","\u0124":"H","\u0126":"H","\u0125":"h","\u0127":"h","\u0128":"I","\u012a":"I","\u012c":"I","\u012e":"I","\u0130":"I","\u0129":"i","\u012b":"i","\u012d":"i","\u012f":"i","\u0131":"i","\u0134":"J","\u0135":"j","\u0136":"K","\u0137":"k","\u0138":"k","\u0139":"L","\u013b":"L","\u013d":"L","\u013f":"L","\u0141":"L","\u013a":"l","\u013c":"l","\u013e":"l","\u0140":"l","\u0142":"l","\u0143":"N","\u0145":"N","\u0147":"N","\u014a":"N","\u0144":"n","\u0146":"n","\u0148":"n","\u014b":"n","\u014c":"O",
    	"\u014e":"O","\u0150":"O","\u014d":"o","\u014f":"o","\u0151":"o","\u0154":"R","\u0156":"R","\u0158":"R","\u0155":"r","\u0157":"r","\u0159":"r","\u015a":"S","\u015c":"S","\u015e":"S","\u0160":"S","\u015b":"s","\u015d":"s","\u015f":"s","\u0161":"s","\u0162":"T","\u0164":"T","\u0166":"T","\u0163":"t","\u0165":"t","\u0167":"t","\u0168":"U","\u016a":"U","\u016c":"U","\u016e":"U","\u0170":"U","\u0172":"U","\u0169":"u","\u016b":"u","\u016d":"u","\u016f":"u","\u0171":"u","\u0173":"u","\u0174":"W","\u0175":"w",
    	"\u0176":"Y","\u0177":"y","\u0178":"Y","\u0179":"Z","\u017b":"Z","\u017d":"Z","\u017a":"z","\u017c":"z","\u017e":"z","\u0132":"IJ","\u0133":"ij","\u0152":"Oe","\u0153":"oe","\u0149":"'n","\u017f":"s"},Hr={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"},Jr={"&amp;":"&","&lt;":"<","&gt;":">","&quot;":'"',"&#39;":"'"},Yr={"\\":"\\","'":"'","\n":"n","\r":"r","\u2028":"u2028","\u2029":"u2029"},Qr=parseFloat,Xr=parseInt,ne="object"==typeof commonjsGlobal&&commonjsGlobal&&commonjsGlobal.Object===Object&&commonjsGlobal,te="object"==typeof self&&self&&self.Object===Object&&self,re=ne||te||Function("return this")(),ee=exports&&!exports.nodeType&&exports,ue=ee&&"object"=='object'&&module&&!module.nodeType&&module,ie=ue&&ue.exports===ee,oe=ie&&ne.process,fe=function(){
    	try{var n=ue&&ue.require&&ue.require("util").types;return n?n:oe&&oe.binding&&oe.binding("util")}catch(n){}}(),ce=fe&&fe.isArrayBuffer,ae=fe&&fe.isDate,le=fe&&fe.isMap,se=fe&&fe.isRegExp,he=fe&&fe.isSet,pe=fe&&fe.isTypedArray,_e=m("length"),ve=x(Gr),ge=x(Hr),ye=x(Jr),de=function p(x){function Z(n){if(cc(n)&&!bh(n)&&!(n instanceof Ct)){if(n instanceof Y)return n;if(bl.call(n,"__wrapped__"))return eo(n)}return new Y(n)}function J(){}function Y(n,t){this.__wrapped__=n,this.__actions__=[],this.__chain__=!!t,
    	this.__index__=0,this.__values__=X;}function Ct(n){this.__wrapped__=n,this.__actions__=[],this.__dir__=1,this.__filtered__=!1,this.__iteratees__=[],this.__takeCount__=Un,this.__views__=[];}function $t(){var n=new Ct(this.__wrapped__);return n.__actions__=Tu(this.__actions__),n.__dir__=this.__dir__,n.__filtered__=this.__filtered__,n.__iteratees__=Tu(this.__iteratees__),n.__takeCount__=this.__takeCount__,n.__views__=Tu(this.__views__),n}function Yt(){if(this.__filtered__){var n=new Ct(this);n.__dir__=-1,
    	n.__filtered__=!0;}else n=this.clone(),n.__dir__*=-1;return n}function Qt(){var n=this.__wrapped__.value(),t=this.__dir__,r=bh(n),e=t<0,u=r?n.length:0,i=Oi(0,u,this.__views__),o=i.start,f=i.end,c=f-o,a=e?f:o-1,l=this.__iteratees__,s=l.length,h=0,p=Hl(c,this.__takeCount__);if(!r||!e&&u==c&&p==c)return wu(n,this.__actions__);var _=[];n:for(;c--&&h<p;){a+=t;for(var v=-1,g=n[a];++v<s;){var y=l[v],d=y.iteratee,b=y.type,w=d(g);if(b==zn)g=w;else if(!w){if(b==Rn)continue n;break n}}_[h++]=g;}return _}function Xt(n){
    	var t=-1,r=null==n?0:n.length;for(this.clear();++t<r;){var e=n[t];this.set(e[0],e[1]);}}function nr(){this.__data__=is?is(null):{},this.size=0;}function tr(n){var t=this.has(n)&&delete this.__data__[n];return this.size-=t?1:0,t}function rr(n){var t=this.__data__;if(is){var r=t[n];return r===on?X:r}return bl.call(t,n)?t[n]:X}function er(n){var t=this.__data__;return is?t[n]!==X:bl.call(t,n)}function ur(n,t){var r=this.__data__;return this.size+=this.has(n)?0:1,r[n]=is&&t===X?on:t,this}function ir(n){
    	var t=-1,r=null==n?0:n.length;for(this.clear();++t<r;){var e=n[t];this.set(e[0],e[1]);}}function or(){this.__data__=[],this.size=0;}function fr(n){var t=this.__data__,r=Wr(t,n);return !(r<0)&&(r==t.length-1?t.pop():Ll.call(t,r,1),--this.size,!0)}function cr(n){var t=this.__data__,r=Wr(t,n);return r<0?X:t[r][1]}function ar(n){return Wr(this.__data__,n)>-1}function lr(n,t){var r=this.__data__,e=Wr(r,n);return e<0?(++this.size,r.push([n,t])):r[e][1]=t,this}function sr(n){var t=-1,r=null==n?0:n.length;for(this.clear();++t<r;){
    	var e=n[t];this.set(e[0],e[1]);}}function hr(){this.size=0,this.__data__={hash:new Xt,map:new(ts||ir),string:new Xt};}function pr(n){var t=xi(this,n).delete(n);return this.size-=t?1:0,t}function _r(n){return xi(this,n).get(n)}function vr(n){return xi(this,n).has(n)}function gr(n,t){var r=xi(this,n),e=r.size;return r.set(n,t),this.size+=r.size==e?0:1,this}function yr(n){var t=-1,r=null==n?0:n.length;for(this.__data__=new sr;++t<r;)this.add(n[t]);}function dr(n){return this.__data__.set(n,on),this}function br(n){
    	return this.__data__.has(n)}function wr(n){this.size=(this.__data__=new ir(n)).size;}function mr(){this.__data__=new ir,this.size=0;}function xr(n){var t=this.__data__,r=t.delete(n);return this.size=t.size,r}function jr(n){return this.__data__.get(n)}function Ar(n){return this.__data__.has(n)}function kr(n,t){var r=this.__data__;if(r instanceof ir){var e=r.__data__;if(!ts||e.length<tn-1)return e.push([n,t]),this.size=++r.size,this;r=this.__data__=new sr(e);}return r.set(n,t),this.size=r.size,this}function Or(n,t){
    	var r=bh(n),e=!r&&dh(n),u=!r&&!e&&mh(n),i=!r&&!e&&!u&&Oh(n),o=r||e||u||i,f=o?O(n.length,hl):[],c=f.length;for(var a in n)!t&&!bl.call(n,a)||o&&("length"==a||u&&("offset"==a||"parent"==a)||i&&("buffer"==a||"byteLength"==a||"byteOffset"==a)||Ci(a,c))||f.push(a);return f}function Ir(n){var t=n.length;return t?n[tu(0,t-1)]:X}function Rr(n,t){return Xi(Tu(n),Mr(t,0,n.length))}function zr(n){return Xi(Tu(n))}function Er(n,t,r){(r===X||Gf(n[t],r))&&(r!==X||t in n)||Br(n,t,r);}function Sr(n,t,r){var e=n[t];
    	bl.call(n,t)&&Gf(e,r)&&(r!==X||t in n)||Br(n,t,r);}function Wr(n,t){for(var r=n.length;r--;)if(Gf(n[r][0],t))return r;return -1}function Lr(n,t,r,e){return ys(n,function(n,u,i){t(e,n,r(n),i);}),e}function Cr(n,t){return n&&$u(t,Pc(t),n)}function Ur(n,t){return n&&$u(t,qc(t),n)}function Br(n,t,r){"__proto__"==t&&Tl?Tl(n,t,{configurable:!0,enumerable:!0,value:r,writable:!0}):n[t]=r;}function Tr(n,t){for(var r=-1,e=t.length,u=il(e),i=null==n;++r<e;)u[r]=i?X:Mc(n,t[r]);return u}function Mr(n,t,r){return n===n&&(r!==X&&(n=n<=r?n:r),
    	t!==X&&(n=n>=t?n:t)),n}function Fr(n,t,e,u,i,o){var f,c=t&an,a=t&ln,l=t&sn;if(e&&(f=i?e(n,u,i,o):e(n)),f!==X)return f;if(!fc(n))return n;var s=bh(n);if(s){if(f=zi(n),!c)return Tu(n,f)}else {var h=zs(n),p=h==Kn||h==Vn;if(mh(n))return Iu(n,c);if(h==Yn||h==Dn||p&&!i){if(f=a||p?{}:Ei(n),!c)return a?Mu(n,Ur(f,n)):Du(n,Cr(f,n))}else {if(!Vr[h])return i?n:{};f=Si(n,h,c);}}o||(o=new wr);var _=o.get(n);if(_)return _;o.set(n,f),kh(n)?n.forEach(function(r){f.add(Fr(r,t,e,r,n,o));}):jh(n)&&n.forEach(function(r,u){
    	f.set(u,Fr(r,t,e,u,n,o));});var v=l?a?di:yi:a?qc:Pc,g=s?X:v(n);return r(g||n,function(r,u){g&&(u=r,r=n[u]),Sr(f,u,Fr(r,t,e,u,n,o));}),f}function Nr(n){var t=Pc(n);return function(r){return Pr(r,n,t)}}function Pr(n,t,r){var e=r.length;if(null==n)return !e;for(n=ll(n);e--;){var u=r[e],i=t[u],o=n[u];if(o===X&&!(u in n)||!i(o))return !1}return !0}function Gr(n,t,r){if("function"!=typeof n)throw new pl(en);return Ws(function(){n.apply(X,r);},t)}function Hr(n,t,r,e){var u=-1,i=o,a=!0,l=n.length,s=[],h=t.length;
    	if(!l)return s;r&&(t=c(t,z(r))),e?(i=f,a=!1):t.length>=tn&&(i=S,a=!1,t=new yr(t));n:for(;++u<l;){var p=n[u],_=null==r?p:r(p);if(p=e||0!==p?p:0,a&&_===_){for(var v=h;v--;)if(t[v]===_)continue n;s.push(p);}else i(t,_,e)||s.push(p);}return s}function Jr(n,t){var r=!0;return ys(n,function(n,e,u){return r=!!t(n,e,u)}),r}function Yr(n,t,r){for(var e=-1,u=n.length;++e<u;){var i=n[e],o=t(i);if(null!=o&&(f===X?o===o&&!bc(o):r(o,f)))var f=o,c=i;}return c}function ne(n,t,r,e){var u=n.length;for(r=kc(r),r<0&&(r=-r>u?0:u+r),
    	e=e===X||e>u?u:kc(e),e<0&&(e+=u),e=r>e?0:Oc(e);r<e;)n[r++]=t;return n}function te(n,t){var r=[];return ys(n,function(n,e,u){t(n,e,u)&&r.push(n);}),r}function ee(n,t,r,e,u){var i=-1,o=n.length;for(r||(r=Li),u||(u=[]);++i<o;){var f=n[i];t>0&&r(f)?t>1?ee(f,t-1,r,e,u):a(u,f):e||(u[u.length]=f);}return u}function ue(n,t){return n&&bs(n,t,Pc)}function oe(n,t){return n&&ws(n,t,Pc)}function fe(n,t){return i(t,function(t){return uc(n[t])})}function _e(n,t){t=ku(t,n);for(var r=0,e=t.length;null!=n&&r<e;)n=n[no(t[r++])];
    	return r&&r==e?n:X}function de(n,t,r){var e=t(n);return bh(n)?e:a(e,r(n))}function we(n){return null==n?n===X?ut:Jn:Bl&&Bl in ll(n)?ki(n):Ki(n)}function me(n,t){return n>t}function xe(n,t){return null!=n&&bl.call(n,t)}function je(n,t){return null!=n&&t in ll(n)}function Ae(n,t,r){return n>=Hl(t,r)&&n<Gl(t,r)}function ke(n,t,r){for(var e=r?f:o,u=n[0].length,i=n.length,a=i,l=il(i),s=1/0,h=[];a--;){var p=n[a];a&&t&&(p=c(p,z(t))),s=Hl(p.length,s),l[a]=!r&&(t||u>=120&&p.length>=120)?new yr(a&&p):X;}p=n[0];
    	var _=-1,v=l[0];n:for(;++_<u&&h.length<s;){var g=p[_],y=t?t(g):g;if(g=r||0!==g?g:0,!(v?S(v,y):e(h,y,r))){for(a=i;--a;){var d=l[a];if(!(d?S(d,y):e(n[a],y,r)))continue n}v&&v.push(y),h.push(g);}}return h}function Oe(n,t,r,e){return ue(n,function(n,u,i){t(e,r(n),u,i);}),e}function Ie(t,r,e){r=ku(r,t),t=Gi(t,r);var u=null==t?t:t[no(jo(r))];return null==u?X:n(u,t,e)}function Re(n){return cc(n)&&we(n)==Dn}function ze(n){return cc(n)&&we(n)==ft}function Ee(n){return cc(n)&&we(n)==Pn}function Se(n,t,r,e,u){
    	return n===t||(null==n||null==t||!cc(n)&&!cc(t)?n!==n&&t!==t:We(n,t,r,e,Se,u))}function We(n,t,r,e,u,i){var o=bh(n),f=bh(t),c=o?Mn:zs(n),a=f?Mn:zs(t);c=c==Dn?Yn:c,a=a==Dn?Yn:a;var l=c==Yn,s=a==Yn,h=c==a;if(h&&mh(n)){if(!mh(t))return !1;o=!0,l=!1;}if(h&&!l)return i||(i=new wr),o||Oh(n)?pi(n,t,r,e,u,i):_i(n,t,c,r,e,u,i);if(!(r&hn)){var p=l&&bl.call(n,"__wrapped__"),_=s&&bl.call(t,"__wrapped__");if(p||_){var v=p?n.value():n,g=_?t.value():t;return i||(i=new wr),u(v,g,r,e,i)}}return !!h&&(i||(i=new wr),vi(n,t,r,e,u,i));
    	}function Le(n){return cc(n)&&zs(n)==Gn}function Ce(n,t,r,e){var u=r.length,i=u,o=!e;if(null==n)return !i;for(n=ll(n);u--;){var f=r[u];if(o&&f[2]?f[1]!==n[f[0]]:!(f[0]in n))return !1}for(;++u<i;){f=r[u];var c=f[0],a=n[c],l=f[1];if(o&&f[2]){if(a===X&&!(c in n))return !1}else {var s=new wr;if(e)var h=e(a,l,c,n,t,s);if(!(h===X?Se(l,a,hn|pn,e,s):h))return !1}}return !0}function Ue(n){return !(!fc(n)||Di(n))&&(uc(n)?kl:Zt).test(to(n))}function Be(n){return cc(n)&&we(n)==nt}function Te(n){return cc(n)&&zs(n)==tt;
    	}function $e(n){return cc(n)&&oc(n.length)&&!!Kr[we(n)]}function De(n){return "function"==typeof n?n:null==n?La:"object"==typeof n?bh(n)?Ze(n[0],n[1]):qe(n):Fa(n)}function Me(n){if(!Mi(n))return Vl(n);var t=[];for(var r in ll(n))bl.call(n,r)&&"constructor"!=r&&t.push(r);return t}function Fe(n){if(!fc(n))return Zi(n);var t=Mi(n),r=[];for(var e in n)("constructor"!=e||!t&&bl.call(n,e))&&r.push(e);return r}function Ne(n,t){return n<t}function Pe(n,t){var r=-1,e=Hf(n)?il(n.length):[];return ys(n,function(n,u,i){
    	e[++r]=t(n,u,i);}),e}function qe(n){var t=ji(n);return 1==t.length&&t[0][2]?Ni(t[0][0],t[0][1]):function(r){return r===n||Ce(r,n,t)}}function Ze(n,t){return Bi(n)&&Fi(t)?Ni(no(n),t):function(r){var e=Mc(r,n);return e===X&&e===t?Nc(r,n):Se(t,e,hn|pn)}}function Ke(n,t,r,e,u){n!==t&&bs(t,function(i,o){if(u||(u=new wr),fc(i))Ve(n,t,o,r,Ke,e,u);else {var f=e?e(Ji(n,o),i,o+"",n,t,u):X;f===X&&(f=i),Er(n,o,f);}},qc);}function Ve(n,t,r,e,u,i,o){var f=Ji(n,r),c=Ji(t,r),a=o.get(c);if(a)return Er(n,r,a),X;var l=i?i(f,c,r+"",n,t,o):X,s=l===X;
    	if(s){var h=bh(c),p=!h&&mh(c),_=!h&&!p&&Oh(c);l=c,h||p||_?bh(f)?l=f:Jf(f)?l=Tu(f):p?(s=!1,l=Iu(c,!0)):_?(s=!1,l=Wu(c,!0)):l=[]:gc(c)||dh(c)?(l=f,dh(f)?l=Rc(f):fc(f)&&!uc(f)||(l=Ei(c))):s=!1;}s&&(o.set(c,l),u(l,c,e,i,o),o.delete(c)),Er(n,r,l);}function Ge(n,t){var r=n.length;if(r)return t+=t<0?r:0,Ci(t,r)?n[t]:X}function He(n,t,r){t=t.length?c(t,function(n){return bh(n)?function(t){return _e(t,1===n.length?n[0]:n)}:n}):[La];var e=-1;return t=c(t,z(mi())),A(Pe(n,function(n,r,u){return {criteria:c(t,function(t){
    	return t(n)}),index:++e,value:n}}),function(n,t){return Cu(n,t,r)})}function Je(n,t){return Ye(n,t,function(t,r){return Nc(n,r)})}function Ye(n,t,r){for(var e=-1,u=t.length,i={};++e<u;){var o=t[e],f=_e(n,o);r(f,o)&&fu(i,ku(o,n),f);}return i}function Qe(n){return function(t){return _e(t,n)}}function Xe(n,t,r,e){var u=e?d:y,i=-1,o=t.length,f=n;for(n===t&&(t=Tu(t)),r&&(f=c(n,z(r)));++i<o;)for(var a=0,l=t[i],s=r?r(l):l;(a=u(f,s,a,e))>-1;)f!==n&&Ll.call(f,a,1),Ll.call(n,a,1);return n}function nu(n,t){for(var r=n?t.length:0,e=r-1;r--;){
    	var u=t[r];if(r==e||u!==i){var i=u;Ci(u)?Ll.call(n,u,1):yu(n,u);}}return n}function tu(n,t){return n+Nl(Ql()*(t-n+1))}function ru(n,t,r,e){for(var u=-1,i=Gl(Fl((t-n)/(r||1)),0),o=il(i);i--;)o[e?i:++u]=n,n+=r;return o}function eu(n,t){var r="";if(!n||t<1||t>Wn)return r;do t%2&&(r+=n),t=Nl(t/2),t&&(n+=n);while(t);return r}function uu(n,t){return Ls(Vi(n,t,La),n+"")}function iu(n){return Ir(ra(n))}function ou(n,t){var r=ra(n);return Xi(r,Mr(t,0,r.length))}function fu(n,t,r,e){if(!fc(n))return n;t=ku(t,n);
    	for(var u=-1,i=t.length,o=i-1,f=n;null!=f&&++u<i;){var c=no(t[u]),a=r;if("__proto__"===c||"constructor"===c||"prototype"===c)return n;if(u!=o){var l=f[c];a=e?e(l,c,f):X,a===X&&(a=fc(l)?l:Ci(t[u+1])?[]:{});}Sr(f,c,a),f=f[c];}return n}function cu(n){return Xi(ra(n))}function au(n,t,r){var e=-1,u=n.length;t<0&&(t=-t>u?0:u+t),r=r>u?u:r,r<0&&(r+=u),u=t>r?0:r-t>>>0,t>>>=0;for(var i=il(u);++e<u;)i[e]=n[e+t];return i}function lu(n,t){var r;return ys(n,function(n,e,u){return r=t(n,e,u),!r}),!!r}function su(n,t,r){
    	var e=0,u=null==n?e:n.length;if("number"==typeof t&&t===t&&u<=Tn){for(;e<u;){var i=e+u>>>1,o=n[i];null!==o&&!bc(o)&&(r?o<=t:o<t)?e=i+1:u=i;}return u}return hu(n,t,La,r)}function hu(n,t,r,e){var u=0,i=null==n?0:n.length;if(0===i)return 0;t=r(t);for(var o=t!==t,f=null===t,c=bc(t),a=t===X;u<i;){var l=Nl((u+i)/2),s=r(n[l]),h=s!==X,p=null===s,_=s===s,v=bc(s);if(o)var g=e||_;else g=a?_&&(e||h):f?_&&h&&(e||!p):c?_&&h&&!p&&(e||!v):!p&&!v&&(e?s<=t:s<t);g?u=l+1:i=l;}return Hl(i,Bn)}function pu(n,t){for(var r=-1,e=n.length,u=0,i=[];++r<e;){
    	var o=n[r],f=t?t(o):o;if(!r||!Gf(f,c)){var c=f;i[u++]=0===o?0:o;}}return i}function _u(n){return "number"==typeof n?n:bc(n)?Cn:+n}function vu(n){if("string"==typeof n)return n;if(bh(n))return c(n,vu)+"";if(bc(n))return vs?vs.call(n):"";var t=n+"";return "0"==t&&1/n==-Sn?"-0":t}function gu(n,t,r){var e=-1,u=o,i=n.length,c=!0,a=[],l=a;if(r)c=!1,u=f;else if(i>=tn){var s=t?null:ks(n);if(s)return P(s);c=!1,u=S,l=new yr;}else l=t?[]:a;n:for(;++e<i;){var h=n[e],p=t?t(h):h;if(h=r||0!==h?h:0,c&&p===p){for(var _=l.length;_--;)if(l[_]===p)continue n;
    	t&&l.push(p),a.push(h);}else u(l,p,r)||(l!==a&&l.push(p),a.push(h));}return a}function yu(n,t){return t=ku(t,n),n=Gi(n,t),null==n||delete n[no(jo(t))]}function du(n,t,r,e){return fu(n,t,r(_e(n,t)),e)}function bu(n,t,r,e){for(var u=n.length,i=e?u:-1;(e?i--:++i<u)&&t(n[i],i,n););return r?au(n,e?0:i,e?i+1:u):au(n,e?i+1:0,e?u:i)}function wu(n,t){var r=n;return r instanceof Ct&&(r=r.value()),l(t,function(n,t){return t.func.apply(t.thisArg,a([n],t.args))},r)}function mu(n,t,r){var e=n.length;if(e<2)return e?gu(n[0]):[];
    	for(var u=-1,i=il(e);++u<e;)for(var o=n[u],f=-1;++f<e;)f!=u&&(i[u]=Hr(i[u]||o,n[f],t,r));return gu(ee(i,1),t,r)}function xu(n,t,r){for(var e=-1,u=n.length,i=t.length,o={};++e<u;){r(o,n[e],e<i?t[e]:X);}return o}function ju(n){return Jf(n)?n:[]}function Au(n){return "function"==typeof n?n:La}function ku(n,t){return bh(n)?n:Bi(n,t)?[n]:Cs(Ec(n))}function Ou(n,t,r){var e=n.length;return r=r===X?e:r,!t&&r>=e?n:au(n,t,r)}function Iu(n,t){if(t)return n.slice();var r=n.length,e=zl?zl(r):new n.constructor(r);
    	return n.copy(e),e}function Ru(n){var t=new n.constructor(n.byteLength);return new Rl(t).set(new Rl(n)),t}function zu(n,t){return new n.constructor(t?Ru(n.buffer):n.buffer,n.byteOffset,n.byteLength)}function Eu(n){var t=new n.constructor(n.source,Nt.exec(n));return t.lastIndex=n.lastIndex,t}function Su(n){return _s?ll(_s.call(n)):{}}function Wu(n,t){return new n.constructor(t?Ru(n.buffer):n.buffer,n.byteOffset,n.length)}function Lu(n,t){if(n!==t){var r=n!==X,e=null===n,u=n===n,i=bc(n),o=t!==X,f=null===t,c=t===t,a=bc(t);
    	if(!f&&!a&&!i&&n>t||i&&o&&c&&!f&&!a||e&&o&&c||!r&&c||!u)return 1;if(!e&&!i&&!a&&n<t||a&&r&&u&&!e&&!i||f&&r&&u||!o&&u||!c)return -1}return 0}function Cu(n,t,r){for(var e=-1,u=n.criteria,i=t.criteria,o=u.length,f=r.length;++e<o;){var c=Lu(u[e],i[e]);if(c){if(e>=f)return c;return c*("desc"==r[e]?-1:1)}}return n.index-t.index}function Uu(n,t,r,e){for(var u=-1,i=n.length,o=r.length,f=-1,c=t.length,a=Gl(i-o,0),l=il(c+a),s=!e;++f<c;)l[f]=t[f];for(;++u<o;)(s||u<i)&&(l[r[u]]=n[u]);for(;a--;)l[f++]=n[u++];return l;
    	}function Bu(n,t,r,e){for(var u=-1,i=n.length,o=-1,f=r.length,c=-1,a=t.length,l=Gl(i-f,0),s=il(l+a),h=!e;++u<l;)s[u]=n[u];for(var p=u;++c<a;)s[p+c]=t[c];for(;++o<f;)(h||u<i)&&(s[p+r[o]]=n[u++]);return s}function Tu(n,t){var r=-1,e=n.length;for(t||(t=il(e));++r<e;)t[r]=n[r];return t}function $u(n,t,r,e){var u=!r;r||(r={});for(var i=-1,o=t.length;++i<o;){var f=t[i],c=e?e(r[f],n[f],f,r,n):X;c===X&&(c=n[f]),u?Br(r,f,c):Sr(r,f,c);}return r}function Du(n,t){return $u(n,Is(n),t)}function Mu(n,t){return $u(n,Rs(n),t);
    	}function Fu(n,r){return function(e,u){var i=bh(e)?t:Lr,o=r?r():{};return i(e,n,mi(u,2),o)}}function Nu(n){return uu(function(t,r){var e=-1,u=r.length,i=u>1?r[u-1]:X,o=u>2?r[2]:X;for(i=n.length>3&&"function"==typeof i?(u--,i):X,o&&Ui(r[0],r[1],o)&&(i=u<3?X:i,u=1),t=ll(t);++e<u;){var f=r[e];f&&n(t,f,e,i);}return t})}function Pu(n,t){return function(r,e){if(null==r)return r;if(!Hf(r))return n(r,e);for(var u=r.length,i=t?u:-1,o=ll(r);(t?i--:++i<u)&&e(o[i],i,o)!==!1;);return r}}function qu(n){return function(t,r,e){
    	for(var u=-1,i=ll(t),o=e(t),f=o.length;f--;){var c=o[n?f:++u];if(r(i[c],c,i)===!1)break}return t}}function Zu(n,t,r){function e(){return (this&&this!==re&&this instanceof e?i:n).apply(u?r:this,arguments)}var u=t&_n,i=Gu(n);return e}function Ku(n){return function(t){t=Ec(t);var r=T(t)?G(t):X,e=r?r[0]:t.charAt(0),u=r?Ou(r,1).join(""):t.slice(1);return e[n]()+u}}function Vu(n){return function(t){return l(Ra(ca(t).replace($r,"")),n,"")}}function Gu(n){return function(){var t=arguments;switch(t.length){
    	case 0:return new n;case 1:return new n(t[0]);case 2:return new n(t[0],t[1]);case 3:return new n(t[0],t[1],t[2]);case 4:return new n(t[0],t[1],t[2],t[3]);case 5:return new n(t[0],t[1],t[2],t[3],t[4]);case 6:return new n(t[0],t[1],t[2],t[3],t[4],t[5]);case 7:return new n(t[0],t[1],t[2],t[3],t[4],t[5],t[6])}var r=gs(n.prototype),e=n.apply(r,t);return fc(e)?e:r}}function Hu(t,r,e){function u(){for(var o=arguments.length,f=il(o),c=o,a=wi(u);c--;)f[c]=arguments[c];var l=o<3&&f[0]!==a&&f[o-1]!==a?[]:N(f,a);
    	return o-=l.length,o<e?oi(t,r,Qu,u.placeholder,X,f,l,X,X,e-o):n(this&&this!==re&&this instanceof u?i:t,this,f)}var i=Gu(t);return u}function Ju(n){return function(t,r,e){var u=ll(t);if(!Hf(t)){var i=mi(r,3);t=Pc(t),r=function(n){return i(u[n],n,u)};}var o=n(t,r,e);return o>-1?u[i?t[o]:o]:X}}function Yu(n){return gi(function(t){var r=t.length,e=r,u=Y.prototype.thru;for(n&&t.reverse();e--;){var i=t[e];if("function"!=typeof i)throw new pl(en);if(u&&!o&&"wrapper"==bi(i))var o=new Y([],!0);}for(e=o?e:r;++e<r;){
    	i=t[e];var f=bi(i),c="wrapper"==f?Os(i):X;o=c&&$i(c[0])&&c[1]==(mn|yn|bn|xn)&&!c[4].length&&1==c[9]?o[bi(c[0])].apply(o,c[3]):1==i.length&&$i(i)?o[f]():o.thru(i);}return function(){var n=arguments,e=n[0];if(o&&1==n.length&&bh(e))return o.plant(e).value();for(var u=0,i=r?t[u].apply(this,n):e;++u<r;)i=t[u].call(this,i);return i}})}function Qu(n,t,r,e,u,i,o,f,c,a){function l(){for(var y=arguments.length,d=il(y),b=y;b--;)d[b]=arguments[b];if(_)var w=wi(l),m=C(d,w);if(e&&(d=Uu(d,e,u,_)),i&&(d=Bu(d,i,o,_)),
    	y-=m,_&&y<a){return oi(n,t,Qu,l.placeholder,r,d,N(d,w),f,c,a-y)}var x=h?r:this,j=p?x[n]:n;return y=d.length,f?d=Hi(d,f):v&&y>1&&d.reverse(),s&&c<y&&(d.length=c),this&&this!==re&&this instanceof l&&(j=g||Gu(j)),j.apply(x,d)}var s=t&mn,h=t&_n,p=t&vn,_=t&(yn|dn),v=t&jn,g=p?X:Gu(n);return l}function Xu(n,t){return function(r,e){return Oe(r,n,t(e),{})}}function ni(n,t){return function(r,e){var u;if(r===X&&e===X)return t;if(r!==X&&(u=r),e!==X){if(u===X)return e;"string"==typeof r||"string"==typeof e?(r=vu(r),
    	e=vu(e)):(r=_u(r),e=_u(e)),u=n(r,e);}return u}}function ti(t){return gi(function(r){return r=c(r,z(mi())),uu(function(e){var u=this;return t(r,function(t){return n(t,u,e)})})})}function ri(n,t){t=t===X?" ":vu(t);var r=t.length;if(r<2)return r?eu(t,n):t;var e=eu(t,Fl(n/V(t)));return T(t)?Ou(G(e),0,n).join(""):e.slice(0,n)}function ei(t,r,e,u){function i(){for(var r=-1,c=arguments.length,a=-1,l=u.length,s=il(l+c),h=this&&this!==re&&this instanceof i?f:t;++a<l;)s[a]=u[a];for(;c--;)s[a++]=arguments[++r];
    	return n(h,o?e:this,s)}var o=r&_n,f=Gu(t);return i}function ui(n){return function(t,r,e){return e&&"number"!=typeof e&&Ui(t,r,e)&&(r=e=X),t=Ac(t),r===X?(r=t,t=0):r=Ac(r),e=e===X?t<r?1:-1:Ac(e),ru(t,r,e,n)}}function ii(n){return function(t,r){return "string"==typeof t&&"string"==typeof r||(t=Ic(t),r=Ic(r)),n(t,r)}}function oi(n,t,r,e,u,i,o,f,c,a){var l=t&yn,s=l?o:X,h=l?X:o,p=l?i:X,_=l?X:i;t|=l?bn:wn,t&=~(l?wn:bn),t&gn||(t&=~(_n|vn));var v=[n,t,u,p,s,_,h,f,c,a],g=r.apply(X,v);return $i(n)&&Ss(g,v),g.placeholder=e,
    	Yi(g,n,t)}function fi(n){var t=al[n];return function(n,r){if(n=Ic(n),r=null==r?0:Hl(kc(r),292),r&&Zl(n)){var e=(Ec(n)+"e").split("e");return e=(Ec(t(e[0]+"e"+(+e[1]+r)))+"e").split("e"),+(e[0]+"e"+(+e[1]-r))}return t(n)}}function ci(n){return function(t){var r=zs(t);return r==Gn?M(t):r==tt?q(t):I(t,n(t))}}function ai(n,t,r,e,u,i,o,f){var c=t&vn;if(!c&&"function"!=typeof n)throw new pl(en);var a=e?e.length:0;if(a||(t&=~(bn|wn),e=u=X),o=o===X?o:Gl(kc(o),0),f=f===X?f:kc(f),a-=u?u.length:0,t&wn){var l=e,s=u;
    	e=u=X;}var h=c?X:Os(n),p=[n,t,r,e,u,l,s,i,o,f];if(h&&qi(p,h),n=p[0],t=p[1],r=p[2],e=p[3],u=p[4],f=p[9]=p[9]===X?c?0:n.length:Gl(p[9]-a,0),!f&&t&(yn|dn)&&(t&=~(yn|dn)),t&&t!=_n)_=t==yn||t==dn?Hu(n,t,f):t!=bn&&t!=(_n|bn)||u.length?Qu.apply(X,p):ei(n,t,r,e);else var _=Zu(n,t,r);return Yi((h?ms:Ss)(_,p),n,t)}function li(n,t,r,e){return n===X||Gf(n,gl[r])&&!bl.call(e,r)?t:n}function si(n,t,r,e,u,i){return fc(n)&&fc(t)&&(i.set(t,n),Ke(n,t,X,si,i),i.delete(t)),n}function hi(n){return gc(n)?X:n}function pi(n,t,r,e,u,i){
    	var o=r&hn,f=n.length,c=t.length;if(f!=c&&!(o&&c>f))return !1;var a=i.get(n),l=i.get(t);if(a&&l)return a==t&&l==n;var s=-1,p=!0,_=r&pn?new yr:X;for(i.set(n,t),i.set(t,n);++s<f;){var v=n[s],g=t[s];if(e)var y=o?e(g,v,s,t,n,i):e(v,g,s,n,t,i);if(y!==X){if(y)continue;p=!1;break}if(_){if(!h(t,function(n,t){if(!S(_,t)&&(v===n||u(v,n,r,e,i)))return _.push(t)})){p=!1;break}}else if(v!==g&&!u(v,g,r,e,i)){p=!1;break}}return i.delete(n),i.delete(t),p}function _i(n,t,r,e,u,i,o){switch(r){case ct:if(n.byteLength!=t.byteLength||n.byteOffset!=t.byteOffset)return !1;
    	n=n.buffer,t=t.buffer;case ft:return !(n.byteLength!=t.byteLength||!i(new Rl(n),new Rl(t)));case Nn:case Pn:case Hn:return Gf(+n,+t);case Zn:return n.name==t.name&&n.message==t.message;case nt:case rt:return n==t+"";case Gn:var f=M;case tt:var c=e&hn;if(f||(f=P),n.size!=t.size&&!c)return !1;var a=o.get(n);if(a)return a==t;e|=pn,o.set(n,t);var l=pi(f(n),f(t),e,u,i,o);return o.delete(n),l;case et:if(_s)return _s.call(n)==_s.call(t)}return !1}function vi(n,t,r,e,u,i){var o=r&hn,f=yi(n),c=f.length;if(c!=yi(t).length&&!o)return !1;
    	for(var a=c;a--;){var l=f[a];if(!(o?l in t:bl.call(t,l)))return !1}var s=i.get(n),h=i.get(t);if(s&&h)return s==t&&h==n;var p=!0;i.set(n,t),i.set(t,n);for(var _=o;++a<c;){l=f[a];var v=n[l],g=t[l];if(e)var y=o?e(g,v,l,t,n,i):e(v,g,l,n,t,i);if(!(y===X?v===g||u(v,g,r,e,i):y)){p=!1;break}_||(_="constructor"==l);}if(p&&!_){var d=n.constructor,b=t.constructor;d!=b&&"constructor"in n&&"constructor"in t&&!("function"==typeof d&&d instanceof d&&"function"==typeof b&&b instanceof b)&&(p=!1);}return i.delete(n),
    	i.delete(t),p}function gi(n){return Ls(Vi(n,X,_o),n+"")}function yi(n){return de(n,Pc,Is)}function di(n){return de(n,qc,Rs)}function bi(n){for(var t=n.name+"",r=fs[t],e=bl.call(fs,t)?r.length:0;e--;){var u=r[e],i=u.func;if(null==i||i==n)return u.name}return t}function wi(n){return (bl.call(Z,"placeholder")?Z:n).placeholder}function mi(){var n=Z.iteratee||Ca;return n=n===Ca?De:n,arguments.length?n(arguments[0],arguments[1]):n}function xi(n,t){var r=n.__data__;return Ti(t)?r["string"==typeof t?"string":"hash"]:r.map;
    	}function ji(n){for(var t=Pc(n),r=t.length;r--;){var e=t[r],u=n[e];t[r]=[e,u,Fi(u)];}return t}function Ai(n,t){var r=B(n,t);return Ue(r)?r:X}function ki(n){var t=bl.call(n,Bl),r=n[Bl];try{n[Bl]=X;var e=!0;}catch(n){}var u=xl.call(n);return e&&(t?n[Bl]=r:delete n[Bl]),u}function Oi(n,t,r){for(var e=-1,u=r.length;++e<u;){var i=r[e],o=i.size;switch(i.type){case"drop":n+=o;break;case"dropRight":t-=o;break;case"take":t=Hl(t,n+o);break;case"takeRight":n=Gl(n,t-o);}}return {start:n,end:t}}function Ii(n){var t=n.match(Bt);
    	return t?t[1].split(Tt):[]}function Ri(n,t,r){t=ku(t,n);for(var e=-1,u=t.length,i=!1;++e<u;){var o=no(t[e]);if(!(i=null!=n&&r(n,o)))break;n=n[o];}return i||++e!=u?i:(u=null==n?0:n.length,!!u&&oc(u)&&Ci(o,u)&&(bh(n)||dh(n)))}function zi(n){var t=n.length,r=new n.constructor(t);return t&&"string"==typeof n[0]&&bl.call(n,"index")&&(r.index=n.index,r.input=n.input),r}function Ei(n){return "function"!=typeof n.constructor||Mi(n)?{}:gs(El(n))}function Si(n,t,r){var e=n.constructor;switch(t){case ft:return Ru(n);
    	case Nn:case Pn:return new e(+n);case ct:return zu(n,r);case at:case lt:case st:case ht:case pt:case _t:case vt:case gt:case yt:return Wu(n,r);case Gn:return new e;case Hn:case rt:return new e(n);case nt:return Eu(n);case tt:return new e;case et:return Su(n)}}function Wi(n,t){var r=t.length;if(!r)return n;var e=r-1;return t[e]=(r>1?"& ":"")+t[e],t=t.join(r>2?", ":" "),n.replace(Ut,"{\n/* [wrapped with "+t+"] */\n")}function Li(n){return bh(n)||dh(n)||!!(Cl&&n&&n[Cl])}function Ci(n,t){var r=typeof n;
    	return t=null==t?Wn:t,!!t&&("number"==r||"symbol"!=r&&Vt.test(n))&&n>-1&&n%1==0&&n<t}function Ui(n,t,r){if(!fc(r))return !1;var e=typeof t;return !!("number"==e?Hf(r)&&Ci(t,r.length):"string"==e&&t in r)&&Gf(r[t],n)}function Bi(n,t){if(bh(n))return !1;var r=typeof n;return !("number"!=r&&"symbol"!=r&&"boolean"!=r&&null!=n&&!bc(n))||(zt.test(n)||!Rt.test(n)||null!=t&&n in ll(t))}function Ti(n){var t=typeof n;return "string"==t||"number"==t||"symbol"==t||"boolean"==t?"__proto__"!==n:null===n}function $i(n){
    	var t=bi(n),r=Z[t];if("function"!=typeof r||!(t in Ct.prototype))return !1;if(n===r)return !0;var e=Os(r);return !!e&&n===e[0]}function Di(n){return !!ml&&ml in n}function Mi(n){var t=n&&n.constructor;return n===("function"==typeof t&&t.prototype||gl)}function Fi(n){return n===n&&!fc(n)}function Ni(n,t){return function(r){return null!=r&&(r[n]===t&&(t!==X||n in ll(r)))}}function Pi(n){var t=Cf(n,function(n){return r.size===fn&&r.clear(),n}),r=t.cache;return t}function qi(n,t){var r=n[1],e=t[1],u=r|e,i=u<(_n|vn|mn),o=e==mn&&r==yn||e==mn&&r==xn&&n[7].length<=t[8]||e==(mn|xn)&&t[7].length<=t[8]&&r==yn;
    	if(!i&&!o)return n;e&_n&&(n[2]=t[2],u|=r&_n?0:gn);var f=t[3];if(f){var c=n[3];n[3]=c?Uu(c,f,t[4]):f,n[4]=c?N(n[3],cn):t[4];}return f=t[5],f&&(c=n[5],n[5]=c?Bu(c,f,t[6]):f,n[6]=c?N(n[5],cn):t[6]),f=t[7],f&&(n[7]=f),e&mn&&(n[8]=null==n[8]?t[8]:Hl(n[8],t[8])),null==n[9]&&(n[9]=t[9]),n[0]=t[0],n[1]=u,n}function Zi(n){var t=[];if(null!=n)for(var r in ll(n))t.push(r);return t}function Ki(n){return xl.call(n)}function Vi(t,r,e){return r=Gl(r===X?t.length-1:r,0),function(){for(var u=arguments,i=-1,o=Gl(u.length-r,0),f=il(o);++i<o;)f[i]=u[r+i];
    	i=-1;for(var c=il(r+1);++i<r;)c[i]=u[i];return c[r]=e(f),n(t,this,c)}}function Gi(n,t){return t.length<2?n:_e(n,au(t,0,-1))}function Hi(n,t){for(var r=n.length,e=Hl(t.length,r),u=Tu(n);e--;){var i=t[e];n[e]=Ci(i,r)?u[i]:X;}return n}function Ji(n,t){if(("constructor"!==t||"function"!=typeof n[t])&&"__proto__"!=t)return n[t]}function Yi(n,t,r){var e=t+"";return Ls(n,Wi(e,ro(Ii(e),r)))}function Qi(n){var t=0,r=0;return function(){var e=Jl(),u=In-(e-r);if(r=e,u>0){if(++t>=On)return arguments[0]}else t=0;
    	return n.apply(X,arguments)}}function Xi(n,t){var r=-1,e=n.length,u=e-1;for(t=t===X?e:t;++r<t;){var i=tu(r,u),o=n[i];n[i]=n[r],n[r]=o;}return n.length=t,n}function no(n){if("string"==typeof n||bc(n))return n;var t=n+"";return "0"==t&&1/n==-Sn?"-0":t}function to(n){if(null!=n){try{return dl.call(n)}catch(n){}try{return n+""}catch(n){}}return ""}function ro(n,t){return r($n,function(r){var e="_."+r[0];t&r[1]&&!o(n,e)&&n.push(e);}),n.sort()}function eo(n){if(n instanceof Ct)return n.clone();var t=new Y(n.__wrapped__,n.__chain__);
    	return t.__actions__=Tu(n.__actions__),t.__index__=n.__index__,t.__values__=n.__values__,t}function uo(n,t,r){t=(r?Ui(n,t,r):t===X)?1:Gl(kc(t),0);var e=null==n?0:n.length;if(!e||t<1)return [];for(var u=0,i=0,o=il(Fl(e/t));u<e;)o[i++]=au(n,u,u+=t);return o}function io(n){for(var t=-1,r=null==n?0:n.length,e=0,u=[];++t<r;){var i=n[t];i&&(u[e++]=i);}return u}function oo(){var n=arguments.length;if(!n)return [];for(var t=il(n-1),r=arguments[0],e=n;e--;)t[e-1]=arguments[e];return a(bh(r)?Tu(r):[r],ee(t,1));
    	}function fo(n,t,r){var e=null==n?0:n.length;return e?(t=r||t===X?1:kc(t),au(n,t<0?0:t,e)):[]}function co(n,t,r){var e=null==n?0:n.length;return e?(t=r||t===X?1:kc(t),t=e-t,au(n,0,t<0?0:t)):[]}function ao(n,t){return n&&n.length?bu(n,mi(t,3),!0,!0):[]}function lo(n,t){return n&&n.length?bu(n,mi(t,3),!0):[]}function so(n,t,r,e){var u=null==n?0:n.length;return u?(r&&"number"!=typeof r&&Ui(n,t,r)&&(r=0,e=u),ne(n,t,r,e)):[]}function ho(n,t,r){var e=null==n?0:n.length;if(!e)return -1;var u=null==r?0:kc(r);
    	return u<0&&(u=Gl(e+u,0)),g(n,mi(t,3),u)}function po(n,t,r){var e=null==n?0:n.length;if(!e)return -1;var u=e-1;return r!==X&&(u=kc(r),u=r<0?Gl(e+u,0):Hl(u,e-1)),g(n,mi(t,3),u,!0)}function _o(n){return (null==n?0:n.length)?ee(n,1):[]}function vo(n){return (null==n?0:n.length)?ee(n,Sn):[]}function go(n,t){return (null==n?0:n.length)?(t=t===X?1:kc(t),ee(n,t)):[]}function yo(n){for(var t=-1,r=null==n?0:n.length,e={};++t<r;){var u=n[t];e[u[0]]=u[1];}return e}function bo(n){return n&&n.length?n[0]:X}function wo(n,t,r){
    	var e=null==n?0:n.length;if(!e)return -1;var u=null==r?0:kc(r);return u<0&&(u=Gl(e+u,0)),y(n,t,u)}function mo(n){return (null==n?0:n.length)?au(n,0,-1):[]}function xo(n,t){return null==n?"":Kl.call(n,t)}function jo(n){var t=null==n?0:n.length;return t?n[t-1]:X}function Ao(n,t,r){var e=null==n?0:n.length;if(!e)return -1;var u=e;return r!==X&&(u=kc(r),u=u<0?Gl(e+u,0):Hl(u,e-1)),t===t?K(n,t,u):g(n,b,u,!0)}function ko(n,t){return n&&n.length?Ge(n,kc(t)):X}function Oo(n,t){return n&&n.length&&t&&t.length?Xe(n,t):n;
    	}function Io(n,t,r){return n&&n.length&&t&&t.length?Xe(n,t,mi(r,2)):n}function Ro(n,t,r){return n&&n.length&&t&&t.length?Xe(n,t,X,r):n}function zo(n,t){var r=[];if(!n||!n.length)return r;var e=-1,u=[],i=n.length;for(t=mi(t,3);++e<i;){var o=n[e];t(o,e,n)&&(r.push(o),u.push(e));}return nu(n,u),r}function Eo(n){return null==n?n:Xl.call(n)}function So(n,t,r){var e=null==n?0:n.length;return e?(r&&"number"!=typeof r&&Ui(n,t,r)?(t=0,r=e):(t=null==t?0:kc(t),r=r===X?e:kc(r)),au(n,t,r)):[]}function Wo(n,t){
    	return su(n,t)}function Lo(n,t,r){return hu(n,t,mi(r,2))}function Co(n,t){var r=null==n?0:n.length;if(r){var e=su(n,t);if(e<r&&Gf(n[e],t))return e}return -1}function Uo(n,t){return su(n,t,!0)}function Bo(n,t,r){return hu(n,t,mi(r,2),!0)}function To(n,t){if(null==n?0:n.length){var r=su(n,t,!0)-1;if(Gf(n[r],t))return r}return -1}function $o(n){return n&&n.length?pu(n):[]}function Do(n,t){return n&&n.length?pu(n,mi(t,2)):[]}function Mo(n){var t=null==n?0:n.length;return t?au(n,1,t):[]}function Fo(n,t,r){
    	return n&&n.length?(t=r||t===X?1:kc(t),au(n,0,t<0?0:t)):[]}function No(n,t,r){var e=null==n?0:n.length;return e?(t=r||t===X?1:kc(t),t=e-t,au(n,t<0?0:t,e)):[]}function Po(n,t){return n&&n.length?bu(n,mi(t,3),!1,!0):[]}function qo(n,t){return n&&n.length?bu(n,mi(t,3)):[]}function Zo(n){return n&&n.length?gu(n):[]}function Ko(n,t){return n&&n.length?gu(n,mi(t,2)):[]}function Vo(n,t){return t="function"==typeof t?t:X,n&&n.length?gu(n,X,t):[]}function Go(n){if(!n||!n.length)return [];var t=0;return n=i(n,function(n){
    	if(Jf(n))return t=Gl(n.length,t),!0}),O(t,function(t){return c(n,m(t))})}function Ho(t,r){if(!t||!t.length)return [];var e=Go(t);return null==r?e:c(e,function(t){return n(r,X,t)})}function Jo(n,t){return xu(n||[],t||[],Sr)}function Yo(n,t){return xu(n||[],t||[],fu)}function Qo(n){var t=Z(n);return t.__chain__=!0,t}function Xo(n,t){return t(n),n}function nf(n,t){return t(n)}function tf(){return Qo(this)}function rf(){return new Y(this.value(),this.__chain__)}function ef(){this.__values__===X&&(this.__values__=jc(this.value()));
    	var n=this.__index__>=this.__values__.length;return {done:n,value:n?X:this.__values__[this.__index__++]}}function uf(){return this}function of(n){for(var t,r=this;r instanceof J;){var e=eo(r);e.__index__=0,e.__values__=X,t?u.__wrapped__=e:t=e;var u=e;r=r.__wrapped__;}return u.__wrapped__=n,t}function ff(){var n=this.__wrapped__;if(n instanceof Ct){var t=n;return this.__actions__.length&&(t=new Ct(this)),t=t.reverse(),t.__actions__.push({func:nf,args:[Eo],thisArg:X}),new Y(t,this.__chain__)}return this.thru(Eo);
    	}function cf(){return wu(this.__wrapped__,this.__actions__)}function af(n,t,r){var e=bh(n)?u:Jr;return r&&Ui(n,t,r)&&(t=X),e(n,mi(t,3))}function lf(n,t){return (bh(n)?i:te)(n,mi(t,3))}function sf(n,t){return ee(yf(n,t),1)}function hf(n,t){return ee(yf(n,t),Sn)}function pf(n,t,r){return r=r===X?1:kc(r),ee(yf(n,t),r)}function _f(n,t){return (bh(n)?r:ys)(n,mi(t,3))}function vf(n,t){return (bh(n)?e:ds)(n,mi(t,3))}function gf(n,t,r,e){n=Hf(n)?n:ra(n),r=r&&!e?kc(r):0;var u=n.length;return r<0&&(r=Gl(u+r,0)),
    	dc(n)?r<=u&&n.indexOf(t,r)>-1:!!u&&y(n,t,r)>-1}function yf(n,t){return (bh(n)?c:Pe)(n,mi(t,3))}function df(n,t,r,e){return null==n?[]:(bh(t)||(t=null==t?[]:[t]),r=e?X:r,bh(r)||(r=null==r?[]:[r]),He(n,t,r))}function bf(n,t,r){var e=bh(n)?l:j,u=arguments.length<3;return e(n,mi(t,4),r,u,ys)}function wf(n,t,r){var e=bh(n)?s:j,u=arguments.length<3;return e(n,mi(t,4),r,u,ds)}function mf(n,t){return (bh(n)?i:te)(n,Uf(mi(t,3)))}function xf(n){return (bh(n)?Ir:iu)(n)}function jf(n,t,r){return t=(r?Ui(n,t,r):t===X)?1:kc(t),
    	(bh(n)?Rr:ou)(n,t)}function Af(n){return (bh(n)?zr:cu)(n)}function kf(n){if(null==n)return 0;if(Hf(n))return dc(n)?V(n):n.length;var t=zs(n);return t==Gn||t==tt?n.size:Me(n).length}function Of(n,t,r){var e=bh(n)?h:lu;return r&&Ui(n,t,r)&&(t=X),e(n,mi(t,3))}function If(n,t){if("function"!=typeof t)throw new pl(en);return n=kc(n),function(){if(--n<1)return t.apply(this,arguments)}}function Rf(n,t,r){return t=r?X:t,t=n&&null==t?n.length:t,ai(n,mn,X,X,X,X,t)}function zf(n,t){var r;if("function"!=typeof t)throw new pl(en);
    	return n=kc(n),function(){return --n>0&&(r=t.apply(this,arguments)),n<=1&&(t=X),r}}function Ef(n,t,r){t=r?X:t;var e=ai(n,yn,X,X,X,X,X,t);return e.placeholder=Ef.placeholder,e}function Sf(n,t,r){t=r?X:t;var e=ai(n,dn,X,X,X,X,X,t);return e.placeholder=Sf.placeholder,e}function Wf(n,t,r){function e(t){var r=h,e=p;return h=p=X,d=t,v=n.apply(e,r)}function u(n){return d=n,g=Ws(f,t),b?e(n):v}function i(n){var r=n-y,e=n-d,u=t-r;return w?Hl(u,_-e):u}function o(n){var r=n-y,e=n-d;return y===X||r>=t||r<0||w&&e>=_;
    	}function f(){var n=fh();return o(n)?c(n):(g=Ws(f,i(n)),X)}function c(n){return g=X,m&&h?e(n):(h=p=X,v)}function a(){g!==X&&As(g),d=0,h=y=p=g=X;}function l(){return g===X?v:c(fh())}function s(){var n=fh(),r=o(n);if(h=arguments,p=this,y=n,r){if(g===X)return u(y);if(w)return As(g),g=Ws(f,t),e(y)}return g===X&&(g=Ws(f,t)),v}var h,p,_,v,g,y,d=0,b=!1,w=!1,m=!0;if("function"!=typeof n)throw new pl(en);return t=Ic(t)||0,fc(r)&&(b=!!r.leading,w="maxWait"in r,_=w?Gl(Ic(r.maxWait)||0,t):_,m="trailing"in r?!!r.trailing:m),
    	s.cancel=a,s.flush=l,s}function Lf(n){return ai(n,jn)}function Cf(n,t){if("function"!=typeof n||null!=t&&"function"!=typeof t)throw new pl(en);var r=function(){var e=arguments,u=t?t.apply(this,e):e[0],i=r.cache;if(i.has(u))return i.get(u);var o=n.apply(this,e);return r.cache=i.set(u,o)||i,o};return r.cache=new(Cf.Cache||sr),r}function Uf(n){if("function"!=typeof n)throw new pl(en);return function(){var t=arguments;switch(t.length){case 0:return !n.call(this);case 1:return !n.call(this,t[0]);case 2:
    	return !n.call(this,t[0],t[1]);case 3:return !n.call(this,t[0],t[1],t[2])}return !n.apply(this,t)}}function Bf(n){return zf(2,n)}function Tf(n,t){if("function"!=typeof n)throw new pl(en);return t=t===X?t:kc(t),uu(n,t)}function $f(t,r){if("function"!=typeof t)throw new pl(en);return r=null==r?0:Gl(kc(r),0),uu(function(e){var u=e[r],i=Ou(e,0,r);return u&&a(i,u),n(t,this,i)})}function Df(n,t,r){var e=!0,u=!0;if("function"!=typeof n)throw new pl(en);return fc(r)&&(e="leading"in r?!!r.leading:e,u="trailing"in r?!!r.trailing:u),
    	Wf(n,t,{leading:e,maxWait:t,trailing:u})}function Mf(n){return Rf(n,1)}function Ff(n,t){return ph(Au(t),n)}function Nf(){if(!arguments.length)return [];var n=arguments[0];return bh(n)?n:[n]}function Pf(n){return Fr(n,sn)}function qf(n,t){return t="function"==typeof t?t:X,Fr(n,sn,t)}function Zf(n){return Fr(n,an|sn)}function Kf(n,t){return t="function"==typeof t?t:X,Fr(n,an|sn,t)}function Vf(n,t){return null==t||Pr(n,t,Pc(t))}function Gf(n,t){return n===t||n!==n&&t!==t}function Hf(n){return null!=n&&oc(n.length)&&!uc(n);
    	}function Jf(n){return cc(n)&&Hf(n)}function Yf(n){return n===!0||n===!1||cc(n)&&we(n)==Nn}function Qf(n){return cc(n)&&1===n.nodeType&&!gc(n)}function Xf(n){if(null==n)return !0;if(Hf(n)&&(bh(n)||"string"==typeof n||"function"==typeof n.splice||mh(n)||Oh(n)||dh(n)))return !n.length;var t=zs(n);if(t==Gn||t==tt)return !n.size;if(Mi(n))return !Me(n).length;for(var r in n)if(bl.call(n,r))return !1;return !0}function nc(n,t){return Se(n,t)}function tc(n,t,r){r="function"==typeof r?r:X;var e=r?r(n,t):X;return e===X?Se(n,t,X,r):!!e;
    	}function rc(n){if(!cc(n))return !1;var t=we(n);return t==Zn||t==qn||"string"==typeof n.message&&"string"==typeof n.name&&!gc(n)}function ec(n){return "number"==typeof n&&Zl(n)}function uc(n){if(!fc(n))return !1;var t=we(n);return t==Kn||t==Vn||t==Fn||t==Xn}function ic(n){return "number"==typeof n&&n==kc(n)}function oc(n){return "number"==typeof n&&n>-1&&n%1==0&&n<=Wn}function fc(n){var t=typeof n;return null!=n&&("object"==t||"function"==t)}function cc(n){return null!=n&&"object"==typeof n}function ac(n,t){
    	return n===t||Ce(n,t,ji(t))}function lc(n,t,r){return r="function"==typeof r?r:X,Ce(n,t,ji(t),r)}function sc(n){return vc(n)&&n!=+n}function hc(n){if(Es(n))throw new fl(rn);return Ue(n)}function pc(n){return null===n}function _c(n){return null==n}function vc(n){return "number"==typeof n||cc(n)&&we(n)==Hn}function gc(n){if(!cc(n)||we(n)!=Yn)return !1;var t=El(n);if(null===t)return !0;var r=bl.call(t,"constructor")&&t.constructor;return "function"==typeof r&&r instanceof r&&dl.call(r)==jl}function yc(n){
    	return ic(n)&&n>=-Wn&&n<=Wn}function dc(n){return "string"==typeof n||!bh(n)&&cc(n)&&we(n)==rt}function bc(n){return "symbol"==typeof n||cc(n)&&we(n)==et}function wc(n){return n===X}function mc(n){return cc(n)&&zs(n)==it}function xc(n){return cc(n)&&we(n)==ot}function jc(n){if(!n)return [];if(Hf(n))return dc(n)?G(n):Tu(n);if(Ul&&n[Ul])return D(n[Ul]());var t=zs(n);return (t==Gn?M:t==tt?P:ra)(n)}function Ac(n){if(!n)return 0===n?n:0;if(n=Ic(n),n===Sn||n===-Sn){return (n<0?-1:1)*Ln}return n===n?n:0}function kc(n){
    	var t=Ac(n),r=t%1;return t===t?r?t-r:t:0}function Oc(n){return n?Mr(kc(n),0,Un):0}function Ic(n){if("number"==typeof n)return n;if(bc(n))return Cn;if(fc(n)){var t="function"==typeof n.valueOf?n.valueOf():n;n=fc(t)?t+"":t;}if("string"!=typeof n)return 0===n?n:+n;n=R(n);var r=qt.test(n);return r||Kt.test(n)?Xr(n.slice(2),r?2:8):Pt.test(n)?Cn:+n}function Rc(n){return $u(n,qc(n))}function zc(n){return n?Mr(kc(n),-Wn,Wn):0===n?n:0}function Ec(n){return null==n?"":vu(n)}function Sc(n,t){var r=gs(n);return null==t?r:Cr(r,t);
    	}function Wc(n,t){return v(n,mi(t,3),ue)}function Lc(n,t){return v(n,mi(t,3),oe)}function Cc(n,t){return null==n?n:bs(n,mi(t,3),qc)}function Uc(n,t){return null==n?n:ws(n,mi(t,3),qc)}function Bc(n,t){return n&&ue(n,mi(t,3))}function Tc(n,t){return n&&oe(n,mi(t,3))}function $c(n){return null==n?[]:fe(n,Pc(n))}function Dc(n){return null==n?[]:fe(n,qc(n))}function Mc(n,t,r){var e=null==n?X:_e(n,t);return e===X?r:e}function Fc(n,t){return null!=n&&Ri(n,t,xe)}function Nc(n,t){return null!=n&&Ri(n,t,je);
    	}function Pc(n){return Hf(n)?Or(n):Me(n)}function qc(n){return Hf(n)?Or(n,!0):Fe(n)}function Zc(n,t){var r={};return t=mi(t,3),ue(n,function(n,e,u){Br(r,t(n,e,u),n);}),r}function Kc(n,t){var r={};return t=mi(t,3),ue(n,function(n,e,u){Br(r,e,t(n,e,u));}),r}function Vc(n,t){return Gc(n,Uf(mi(t)))}function Gc(n,t){if(null==n)return {};var r=c(di(n),function(n){return [n]});return t=mi(t),Ye(n,r,function(n,r){return t(n,r[0])})}function Hc(n,t,r){t=ku(t,n);var e=-1,u=t.length;for(u||(u=1,n=X);++e<u;){var i=null==n?X:n[no(t[e])];
    	i===X&&(e=u,i=r),n=uc(i)?i.call(n):i;}return n}function Jc(n,t,r){return null==n?n:fu(n,t,r)}function Yc(n,t,r,e){return e="function"==typeof e?e:X,null==n?n:fu(n,t,r,e)}function Qc(n,t,e){var u=bh(n),i=u||mh(n)||Oh(n);if(t=mi(t,4),null==e){var o=n&&n.constructor;e=i?u?new o:[]:fc(n)&&uc(o)?gs(El(n)):{};}return (i?r:ue)(n,function(n,r,u){return t(e,n,r,u)}),e}function Xc(n,t){return null==n||yu(n,t)}function na(n,t,r){return null==n?n:du(n,t,Au(r))}function ta(n,t,r,e){return e="function"==typeof e?e:X,
    	null==n?n:du(n,t,Au(r),e)}function ra(n){return null==n?[]:E(n,Pc(n))}function ea(n){return null==n?[]:E(n,qc(n))}function ua(n,t,r){return r===X&&(r=t,t=X),r!==X&&(r=Ic(r),r=r===r?r:0),t!==X&&(t=Ic(t),t=t===t?t:0),Mr(Ic(n),t,r)}function ia(n,t,r){return t=Ac(t),r===X?(r=t,t=0):r=Ac(r),n=Ic(n),Ae(n,t,r)}function oa(n,t,r){if(r&&"boolean"!=typeof r&&Ui(n,t,r)&&(t=r=X),r===X&&("boolean"==typeof t?(r=t,t=X):"boolean"==typeof n&&(r=n,n=X)),n===X&&t===X?(n=0,t=1):(n=Ac(n),t===X?(t=n,n=0):t=Ac(t)),n>t){
    	var e=n;n=t,t=e;}if(r||n%1||t%1){var u=Ql();return Hl(n+u*(t-n+Qr("1e-"+((u+"").length-1))),t)}return tu(n,t)}function fa(n){return Qh(Ec(n).toLowerCase())}function ca(n){return n=Ec(n),n&&n.replace(Gt,ve).replace(Dr,"")}function aa(n,t,r){n=Ec(n),t=vu(t);var e=n.length;r=r===X?e:Mr(kc(r),0,e);var u=r;return r-=t.length,r>=0&&n.slice(r,u)==t}function la(n){return n=Ec(n),n&&At.test(n)?n.replace(xt,ge):n}function sa(n){return n=Ec(n),n&&Wt.test(n)?n.replace(St,"\\$&"):n}function ha(n,t,r){n=Ec(n),t=kc(t);
    	var e=t?V(n):0;if(!t||e>=t)return n;var u=(t-e)/2;return ri(Nl(u),r)+n+ri(Fl(u),r)}function pa(n,t,r){n=Ec(n),t=kc(t);var e=t?V(n):0;return t&&e<t?n+ri(t-e,r):n}function _a(n,t,r){n=Ec(n),t=kc(t);var e=t?V(n):0;return t&&e<t?ri(t-e,r)+n:n}function va(n,t,r){return r||null==t?t=0:t&&(t=+t),Yl(Ec(n).replace(Lt,""),t||0)}function ga(n,t,r){return t=(r?Ui(n,t,r):t===X)?1:kc(t),eu(Ec(n),t)}function ya(){var n=arguments,t=Ec(n[0]);return n.length<3?t:t.replace(n[1],n[2])}function da(n,t,r){return r&&"number"!=typeof r&&Ui(n,t,r)&&(t=r=X),
    	(r=r===X?Un:r>>>0)?(n=Ec(n),n&&("string"==typeof t||null!=t&&!Ah(t))&&(t=vu(t),!t&&T(n))?Ou(G(n),0,r):n.split(t,r)):[]}function ba(n,t,r){return n=Ec(n),r=null==r?0:Mr(kc(r),0,n.length),t=vu(t),n.slice(r,r+t.length)==t}function wa(n,t,r){var e=Z.templateSettings;r&&Ui(n,t,r)&&(t=X),n=Ec(n),t=Sh({},t,e,li);var u,i,o=Sh({},t.imports,e.imports,li),f=Pc(o),c=E(o,f),a=0,l=t.interpolate||Ht,s="__p += '",h=sl((t.escape||Ht).source+"|"+l.source+"|"+(l===It?Ft:Ht).source+"|"+(t.evaluate||Ht).source+"|$","g"),p="//# sourceURL="+(bl.call(t,"sourceURL")?(t.sourceURL+"").replace(/\s/g," "):"lodash.templateSources["+ ++Zr+"]")+"\n";
    	n.replace(h,function(t,r,e,o,f,c){return e||(e=o),s+=n.slice(a,c).replace(Jt,U),r&&(u=!0,s+="' +\n__e("+r+") +\n'"),f&&(i=!0,s+="';\n"+f+";\n__p += '"),e&&(s+="' +\n((__t = ("+e+")) == null ? '' : __t) +\n'"),a=c+t.length,t}),s+="';\n";var _=bl.call(t,"variable")&&t.variable;if(_){if(Dt.test(_))throw new fl(un)}else s="with (obj) {\n"+s+"\n}\n";s=(i?s.replace(dt,""):s).replace(bt,"$1").replace(wt,"$1;"),s="function("+(_||"obj")+") {\n"+(_?"":"obj || (obj = {});\n")+"var __t, __p = ''"+(u?", __e = _.escape":"")+(i?", __j = Array.prototype.join;\nfunction print() { __p += __j.call(arguments, '') }\n":";\n")+s+"return __p\n}";
    	var v=Xh(function(){return cl(f,p+"return "+s).apply(X,c)});if(v.source=s,rc(v))throw v;return v}function ma(n){return Ec(n).toLowerCase()}function xa(n){return Ec(n).toUpperCase()}function ja(n,t,r){if(n=Ec(n),n&&(r||t===X))return R(n);if(!n||!(t=vu(t)))return n;var e=G(n),u=G(t);return Ou(e,W(e,u),L(e,u)+1).join("")}function Aa(n,t,r){if(n=Ec(n),n&&(r||t===X))return n.slice(0,H(n)+1);if(!n||!(t=vu(t)))return n;var e=G(n);return Ou(e,0,L(e,G(t))+1).join("")}function ka(n,t,r){if(n=Ec(n),n&&(r||t===X))return n.replace(Lt,"");
    	if(!n||!(t=vu(t)))return n;var e=G(n);return Ou(e,W(e,G(t))).join("")}function Oa(n,t){var r=An,e=kn;if(fc(t)){var u="separator"in t?t.separator:u;r="length"in t?kc(t.length):r,e="omission"in t?vu(t.omission):e;}n=Ec(n);var i=n.length;if(T(n)){var o=G(n);i=o.length;}if(r>=i)return n;var f=r-V(e);if(f<1)return e;var c=o?Ou(o,0,f).join(""):n.slice(0,f);if(u===X)return c+e;if(o&&(f+=c.length-f),Ah(u)){if(n.slice(f).search(u)){var a,l=c;for(u.global||(u=sl(u.source,Ec(Nt.exec(u))+"g")),u.lastIndex=0;a=u.exec(l);)var s=a.index;
    	c=c.slice(0,s===X?f:s);}}else if(n.indexOf(vu(u),f)!=f){var h=c.lastIndexOf(u);h>-1&&(c=c.slice(0,h));}return c+e}function Ia(n){return n=Ec(n),n&&jt.test(n)?n.replace(mt,ye):n}function Ra(n,t,r){return n=Ec(n),t=r?X:t,t===X?$(n)?Q(n):_(n):n.match(t)||[]}function za(t){var r=null==t?0:t.length,e=mi();return t=r?c(t,function(n){if("function"!=typeof n[1])throw new pl(en);return [e(n[0]),n[1]]}):[],uu(function(e){for(var u=-1;++u<r;){var i=t[u];if(n(i[0],this,e))return n(i[1],this,e)}})}function Ea(n){
    	return Nr(Fr(n,an))}function Sa(n){return function(){return n}}function Wa(n,t){return null==n||n!==n?t:n}function La(n){return n}function Ca(n){return De("function"==typeof n?n:Fr(n,an))}function Ua(n){return qe(Fr(n,an))}function Ba(n,t){return Ze(n,Fr(t,an))}function Ta(n,t,e){var u=Pc(t),i=fe(t,u);null!=e||fc(t)&&(i.length||!u.length)||(e=t,t=n,n=this,i=fe(t,Pc(t)));var o=!(fc(e)&&"chain"in e&&!e.chain),f=uc(n);return r(i,function(r){var e=t[r];n[r]=e,f&&(n.prototype[r]=function(){var t=this.__chain__;
    	if(o||t){var r=n(this.__wrapped__);return (r.__actions__=Tu(this.__actions__)).push({func:e,args:arguments,thisArg:n}),r.__chain__=t,r}return e.apply(n,a([this.value()],arguments))});}),n}function $a(){return re._===this&&(re._=Al),this}function Da(){}function Ma(n){return n=kc(n),uu(function(t){return Ge(t,n)})}function Fa(n){return Bi(n)?m(no(n)):Qe(n)}function Na(n){return function(t){return null==n?X:_e(n,t)}}function Pa(){return []}function qa(){return !1}function Za(){return {}}function Ka(){return "";
    	}function Va(){return !0}function Ga(n,t){if(n=kc(n),n<1||n>Wn)return [];var r=Un,e=Hl(n,Un);t=mi(t),n-=Un;for(var u=O(e,t);++r<n;)t(r);return u}function Ha(n){return bh(n)?c(n,no):bc(n)?[n]:Tu(Cs(Ec(n)))}function Ja(n){var t=++wl;return Ec(n)+t}function Ya(n){return n&&n.length?Yr(n,La,me):X}function Qa(n,t){return n&&n.length?Yr(n,mi(t,2),me):X}function Xa(n){return w(n,La)}function nl(n,t){return w(n,mi(t,2))}function tl(n){return n&&n.length?Yr(n,La,Ne):X}function rl(n,t){return n&&n.length?Yr(n,mi(t,2),Ne):X;
    	}function el(n){return n&&n.length?k(n,La):0}function ul(n,t){return n&&n.length?k(n,mi(t,2)):0}x=null==x?re:be.defaults(re.Object(),x,be.pick(re,qr));var il=x.Array,ol=x.Date,fl=x.Error,cl=x.Function,al=x.Math,ll=x.Object,sl=x.RegExp,hl=x.String,pl=x.TypeError,_l=il.prototype,vl=cl.prototype,gl=ll.prototype,yl=x["__core-js_shared__"],dl=vl.toString,bl=gl.hasOwnProperty,wl=0,ml=function(){var n=/[^.]+$/.exec(yl&&yl.keys&&yl.keys.IE_PROTO||"");return n?"Symbol(src)_1."+n:""}(),xl=gl.toString,jl=dl.call(ll),Al=re._,kl=sl("^"+dl.call(bl).replace(St,"\\$&").replace(/hasOwnProperty|(function).*?(?=\\\()| for .+?(?=\\\])/g,"$1.*?")+"$"),Ol=ie?x.Buffer:X,Il=x.Symbol,Rl=x.Uint8Array,zl=Ol?Ol.allocUnsafe:X,El=F(ll.getPrototypeOf,ll),Sl=ll.create,Wl=gl.propertyIsEnumerable,Ll=_l.splice,Cl=Il?Il.isConcatSpreadable:X,Ul=Il?Il.iterator:X,Bl=Il?Il.toStringTag:X,Tl=function(){
    	try{var n=Ai(ll,"defineProperty");return n({},"",{}),n}catch(n){}}(),$l=x.clearTimeout!==re.clearTimeout&&x.clearTimeout,Dl=ol&&ol.now!==re.Date.now&&ol.now,Ml=x.setTimeout!==re.setTimeout&&x.setTimeout,Fl=al.ceil,Nl=al.floor,Pl=ll.getOwnPropertySymbols,ql=Ol?Ol.isBuffer:X,Zl=x.isFinite,Kl=_l.join,Vl=F(ll.keys,ll),Gl=al.max,Hl=al.min,Jl=ol.now,Yl=x.parseInt,Ql=al.random,Xl=_l.reverse,ns=Ai(x,"DataView"),ts=Ai(x,"Map"),rs=Ai(x,"Promise"),es=Ai(x,"Set"),us=Ai(x,"WeakMap"),is=Ai(ll,"create"),os=us&&new us,fs={},cs=to(ns),as=to(ts),ls=to(rs),ss=to(es),hs=to(us),ps=Il?Il.prototype:X,_s=ps?ps.valueOf:X,vs=ps?ps.toString:X,gs=function(){
    	function n(){}return function(t){if(!fc(t))return {};if(Sl)return Sl(t);n.prototype=t;var r=new n;return n.prototype=X,r}}();Z.templateSettings={escape:kt,evaluate:Ot,interpolate:It,variable:"",imports:{_:Z}},Z.prototype=J.prototype,Z.prototype.constructor=Z,Y.prototype=gs(J.prototype),Y.prototype.constructor=Y,Ct.prototype=gs(J.prototype),Ct.prototype.constructor=Ct,Xt.prototype.clear=nr,Xt.prototype.delete=tr,Xt.prototype.get=rr,Xt.prototype.has=er,Xt.prototype.set=ur,ir.prototype.clear=or,ir.prototype.delete=fr,
    	ir.prototype.get=cr,ir.prototype.has=ar,ir.prototype.set=lr,sr.prototype.clear=hr,sr.prototype.delete=pr,sr.prototype.get=_r,sr.prototype.has=vr,sr.prototype.set=gr,yr.prototype.add=yr.prototype.push=dr,yr.prototype.has=br,wr.prototype.clear=mr,wr.prototype.delete=xr,wr.prototype.get=jr,wr.prototype.has=Ar,wr.prototype.set=kr;var ys=Pu(ue),ds=Pu(oe,!0),bs=qu(),ws=qu(!0),ms=os?function(n,t){return os.set(n,t),n}:La,xs=Tl?function(n,t){return Tl(n,"toString",{configurable:!0,enumerable:!1,value:Sa(t),
    	writable:!0})}:La,js=uu,As=$l||function(n){return re.clearTimeout(n)},ks=es&&1/P(new es([,-0]))[1]==Sn?function(n){return new es(n)}:Da,Os=os?function(n){return os.get(n)}:Da,Is=Pl?function(n){return null==n?[]:(n=ll(n),i(Pl(n),function(t){return Wl.call(n,t)}))}:Pa,Rs=Pl?function(n){for(var t=[];n;)a(t,Is(n)),n=El(n);return t}:Pa,zs=we;(ns&&zs(new ns(new ArrayBuffer(1)))!=ct||ts&&zs(new ts)!=Gn||rs&&zs(rs.resolve())!=Qn||es&&zs(new es)!=tt||us&&zs(new us)!=it)&&(zs=function(n){var t=we(n),r=t==Yn?n.constructor:X,e=r?to(r):"";
    	if(e)switch(e){case cs:return ct;case as:return Gn;case ls:return Qn;case ss:return tt;case hs:return it}return t});var Es=yl?uc:qa,Ss=Qi(ms),Ws=Ml||function(n,t){return re.setTimeout(n,t)},Ls=Qi(xs),Cs=Pi(function(n){var t=[];return 46===n.charCodeAt(0)&&t.push(""),n.replace(Et,function(n,r,e,u){t.push(e?u.replace(Mt,"$1"):r||n);}),t}),Us=uu(function(n,t){return Jf(n)?Hr(n,ee(t,1,Jf,!0)):[]}),Bs=uu(function(n,t){var r=jo(t);return Jf(r)&&(r=X),Jf(n)?Hr(n,ee(t,1,Jf,!0),mi(r,2)):[]}),Ts=uu(function(n,t){
    	var r=jo(t);return Jf(r)&&(r=X),Jf(n)?Hr(n,ee(t,1,Jf,!0),X,r):[]}),$s=uu(function(n){var t=c(n,ju);return t.length&&t[0]===n[0]?ke(t):[]}),Ds=uu(function(n){var t=jo(n),r=c(n,ju);return t===jo(r)?t=X:r.pop(),r.length&&r[0]===n[0]?ke(r,mi(t,2)):[]}),Ms=uu(function(n){var t=jo(n),r=c(n,ju);return t="function"==typeof t?t:X,t&&r.pop(),r.length&&r[0]===n[0]?ke(r,X,t):[]}),Fs=uu(Oo),Ns=gi(function(n,t){var r=null==n?0:n.length,e=Tr(n,t);return nu(n,c(t,function(n){return Ci(n,r)?+n:n}).sort(Lu)),e}),Ps=uu(function(n){
    	return gu(ee(n,1,Jf,!0))}),qs=uu(function(n){var t=jo(n);return Jf(t)&&(t=X),gu(ee(n,1,Jf,!0),mi(t,2))}),Zs=uu(function(n){var t=jo(n);return t="function"==typeof t?t:X,gu(ee(n,1,Jf,!0),X,t)}),Ks=uu(function(n,t){return Jf(n)?Hr(n,t):[]}),Vs=uu(function(n){return mu(i(n,Jf))}),Gs=uu(function(n){var t=jo(n);return Jf(t)&&(t=X),mu(i(n,Jf),mi(t,2))}),Hs=uu(function(n){var t=jo(n);return t="function"==typeof t?t:X,mu(i(n,Jf),X,t)}),Js=uu(Go),Ys=uu(function(n){var t=n.length,r=t>1?n[t-1]:X;return r="function"==typeof r?(n.pop(),
    	r):X,Ho(n,r)}),Qs=gi(function(n){var t=n.length,r=t?n[0]:0,e=this.__wrapped__,u=function(t){return Tr(t,n)};return !(t>1||this.__actions__.length)&&e instanceof Ct&&Ci(r)?(e=e.slice(r,+r+(t?1:0)),e.__actions__.push({func:nf,args:[u],thisArg:X}),new Y(e,this.__chain__).thru(function(n){return t&&!n.length&&n.push(X),n})):this.thru(u)}),Xs=Fu(function(n,t,r){bl.call(n,r)?++n[r]:Br(n,r,1);}),nh=Ju(ho),th=Ju(po),rh=Fu(function(n,t,r){bl.call(n,r)?n[r].push(t):Br(n,r,[t]);}),eh=uu(function(t,r,e){var u=-1,i="function"==typeof r,o=Hf(t)?il(t.length):[];
    	return ys(t,function(t){o[++u]=i?n(r,t,e):Ie(t,r,e);}),o}),uh=Fu(function(n,t,r){Br(n,r,t);}),ih=Fu(function(n,t,r){n[r?0:1].push(t);},function(){return [[],[]]}),oh=uu(function(n,t){if(null==n)return [];var r=t.length;return r>1&&Ui(n,t[0],t[1])?t=[]:r>2&&Ui(t[0],t[1],t[2])&&(t=[t[0]]),He(n,ee(t,1),[])}),fh=Dl||function(){return re.Date.now()},ch=uu(function(n,t,r){var e=_n;if(r.length){var u=N(r,wi(ch));e|=bn;}return ai(n,e,t,r,u)}),ah=uu(function(n,t,r){var e=_n|vn;if(r.length){var u=N(r,wi(ah));e|=bn;
    	}return ai(t,e,n,r,u)}),lh=uu(function(n,t){return Gr(n,1,t)}),sh=uu(function(n,t,r){return Gr(n,Ic(t)||0,r)});Cf.Cache=sr;var hh=js(function(t,r){r=1==r.length&&bh(r[0])?c(r[0],z(mi())):c(ee(r,1),z(mi()));var e=r.length;return uu(function(u){for(var i=-1,o=Hl(u.length,e);++i<o;)u[i]=r[i].call(this,u[i]);return n(t,this,u)})}),ph=uu(function(n,t){return ai(n,bn,X,t,N(t,wi(ph)))}),_h=uu(function(n,t){return ai(n,wn,X,t,N(t,wi(_h)))}),vh=gi(function(n,t){return ai(n,xn,X,X,X,t)}),gh=ii(me),yh=ii(function(n,t){
    	return n>=t}),dh=Re(function(){return arguments}())?Re:function(n){return cc(n)&&bl.call(n,"callee")&&!Wl.call(n,"callee")},bh=il.isArray,wh=ce?z(ce):ze,mh=ql||qa,xh=ae?z(ae):Ee,jh=le?z(le):Le,Ah=se?z(se):Be,kh=he?z(he):Te,Oh=pe?z(pe):$e,Ih=ii(Ne),Rh=ii(function(n,t){return n<=t}),zh=Nu(function(n,t){if(Mi(t)||Hf(t))return $u(t,Pc(t),n),X;for(var r in t)bl.call(t,r)&&Sr(n,r,t[r]);}),Eh=Nu(function(n,t){$u(t,qc(t),n);}),Sh=Nu(function(n,t,r,e){$u(t,qc(t),n,e);}),Wh=Nu(function(n,t,r,e){$u(t,Pc(t),n,e);
    	}),Lh=gi(Tr),Ch=uu(function(n,t){n=ll(n);var r=-1,e=t.length,u=e>2?t[2]:X;for(u&&Ui(t[0],t[1],u)&&(e=1);++r<e;)for(var i=t[r],o=qc(i),f=-1,c=o.length;++f<c;){var a=o[f],l=n[a];(l===X||Gf(l,gl[a])&&!bl.call(n,a))&&(n[a]=i[a]);}return n}),Uh=uu(function(t){return t.push(X,si),n(Mh,X,t)}),Bh=Xu(function(n,t,r){null!=t&&"function"!=typeof t.toString&&(t=xl.call(t)),n[t]=r;},Sa(La)),Th=Xu(function(n,t,r){null!=t&&"function"!=typeof t.toString&&(t=xl.call(t)),bl.call(n,t)?n[t].push(r):n[t]=[r];},mi),$h=uu(Ie),Dh=Nu(function(n,t,r){
    	Ke(n,t,r);}),Mh=Nu(function(n,t,r,e){Ke(n,t,r,e);}),Fh=gi(function(n,t){var r={};if(null==n)return r;var e=!1;t=c(t,function(t){return t=ku(t,n),e||(e=t.length>1),t}),$u(n,di(n),r),e&&(r=Fr(r,an|ln|sn,hi));for(var u=t.length;u--;)yu(r,t[u]);return r}),Nh=gi(function(n,t){return null==n?{}:Je(n,t)}),Ph=ci(Pc),qh=ci(qc),Zh=Vu(function(n,t,r){return t=t.toLowerCase(),n+(r?fa(t):t)}),Kh=Vu(function(n,t,r){return n+(r?"-":"")+t.toLowerCase()}),Vh=Vu(function(n,t,r){return n+(r?" ":"")+t.toLowerCase()}),Gh=Ku("toLowerCase"),Hh=Vu(function(n,t,r){
    	return n+(r?"_":"")+t.toLowerCase()}),Jh=Vu(function(n,t,r){return n+(r?" ":"")+Qh(t)}),Yh=Vu(function(n,t,r){return n+(r?" ":"")+t.toUpperCase()}),Qh=Ku("toUpperCase"),Xh=uu(function(t,r){try{return n(t,X,r)}catch(n){return rc(n)?n:new fl(n)}}),np=gi(function(n,t){return r(t,function(t){t=no(t),Br(n,t,ch(n[t],n));}),n}),tp=Yu(),rp=Yu(!0),ep=uu(function(n,t){return function(r){return Ie(r,n,t)}}),up=uu(function(n,t){return function(r){return Ie(n,r,t)}}),ip=ti(c),op=ti(u),fp=ti(h),cp=ui(),ap=ui(!0),lp=ni(function(n,t){
    	return n+t},0),sp=fi("ceil"),hp=ni(function(n,t){return n/t},1),pp=fi("floor"),_p=ni(function(n,t){return n*t},1),vp=fi("round"),gp=ni(function(n,t){return n-t},0);return Z.after=If,Z.ary=Rf,Z.assign=zh,Z.assignIn=Eh,Z.assignInWith=Sh,Z.assignWith=Wh,Z.at=Lh,Z.before=zf,Z.bind=ch,Z.bindAll=np,Z.bindKey=ah,Z.castArray=Nf,Z.chain=Qo,Z.chunk=uo,Z.compact=io,Z.concat=oo,Z.cond=za,Z.conforms=Ea,Z.constant=Sa,Z.countBy=Xs,Z.create=Sc,Z.curry=Ef,Z.curryRight=Sf,Z.debounce=Wf,Z.defaults=Ch,Z.defaultsDeep=Uh,
    	Z.defer=lh,Z.delay=sh,Z.difference=Us,Z.differenceBy=Bs,Z.differenceWith=Ts,Z.drop=fo,Z.dropRight=co,Z.dropRightWhile=ao,Z.dropWhile=lo,Z.fill=so,Z.filter=lf,Z.flatMap=sf,Z.flatMapDeep=hf,Z.flatMapDepth=pf,Z.flatten=_o,Z.flattenDeep=vo,Z.flattenDepth=go,Z.flip=Lf,Z.flow=tp,Z.flowRight=rp,Z.fromPairs=yo,Z.functions=$c,Z.functionsIn=Dc,Z.groupBy=rh,Z.initial=mo,Z.intersection=$s,Z.intersectionBy=Ds,Z.intersectionWith=Ms,Z.invert=Bh,Z.invertBy=Th,Z.invokeMap=eh,Z.iteratee=Ca,Z.keyBy=uh,Z.keys=Pc,Z.keysIn=qc,
    	Z.map=yf,Z.mapKeys=Zc,Z.mapValues=Kc,Z.matches=Ua,Z.matchesProperty=Ba,Z.memoize=Cf,Z.merge=Dh,Z.mergeWith=Mh,Z.method=ep,Z.methodOf=up,Z.mixin=Ta,Z.negate=Uf,Z.nthArg=Ma,Z.omit=Fh,Z.omitBy=Vc,Z.once=Bf,Z.orderBy=df,Z.over=ip,Z.overArgs=hh,Z.overEvery=op,Z.overSome=fp,Z.partial=ph,Z.partialRight=_h,Z.partition=ih,Z.pick=Nh,Z.pickBy=Gc,Z.property=Fa,Z.propertyOf=Na,Z.pull=Fs,Z.pullAll=Oo,Z.pullAllBy=Io,Z.pullAllWith=Ro,Z.pullAt=Ns,Z.range=cp,Z.rangeRight=ap,Z.rearg=vh,Z.reject=mf,Z.remove=zo,Z.rest=Tf,
    	Z.reverse=Eo,Z.sampleSize=jf,Z.set=Jc,Z.setWith=Yc,Z.shuffle=Af,Z.slice=So,Z.sortBy=oh,Z.sortedUniq=$o,Z.sortedUniqBy=Do,Z.split=da,Z.spread=$f,Z.tail=Mo,Z.take=Fo,Z.takeRight=No,Z.takeRightWhile=Po,Z.takeWhile=qo,Z.tap=Xo,Z.throttle=Df,Z.thru=nf,Z.toArray=jc,Z.toPairs=Ph,Z.toPairsIn=qh,Z.toPath=Ha,Z.toPlainObject=Rc,Z.transform=Qc,Z.unary=Mf,Z.union=Ps,Z.unionBy=qs,Z.unionWith=Zs,Z.uniq=Zo,Z.uniqBy=Ko,Z.uniqWith=Vo,Z.unset=Xc,Z.unzip=Go,Z.unzipWith=Ho,Z.update=na,Z.updateWith=ta,Z.values=ra,Z.valuesIn=ea,
    	Z.without=Ks,Z.words=Ra,Z.wrap=Ff,Z.xor=Vs,Z.xorBy=Gs,Z.xorWith=Hs,Z.zip=Js,Z.zipObject=Jo,Z.zipObjectDeep=Yo,Z.zipWith=Ys,Z.entries=Ph,Z.entriesIn=qh,Z.extend=Eh,Z.extendWith=Sh,Ta(Z,Z),Z.add=lp,Z.attempt=Xh,Z.camelCase=Zh,Z.capitalize=fa,Z.ceil=sp,Z.clamp=ua,Z.clone=Pf,Z.cloneDeep=Zf,Z.cloneDeepWith=Kf,Z.cloneWith=qf,Z.conformsTo=Vf,Z.deburr=ca,Z.defaultTo=Wa,Z.divide=hp,Z.endsWith=aa,Z.eq=Gf,Z.escape=la,Z.escapeRegExp=sa,Z.every=af,Z.find=nh,Z.findIndex=ho,Z.findKey=Wc,Z.findLast=th,Z.findLastIndex=po,
    	Z.findLastKey=Lc,Z.floor=pp,Z.forEach=_f,Z.forEachRight=vf,Z.forIn=Cc,Z.forInRight=Uc,Z.forOwn=Bc,Z.forOwnRight=Tc,Z.get=Mc,Z.gt=gh,Z.gte=yh,Z.has=Fc,Z.hasIn=Nc,Z.head=bo,Z.identity=La,Z.includes=gf,Z.indexOf=wo,Z.inRange=ia,Z.invoke=$h,Z.isArguments=dh,Z.isArray=bh,Z.isArrayBuffer=wh,Z.isArrayLike=Hf,Z.isArrayLikeObject=Jf,Z.isBoolean=Yf,Z.isBuffer=mh,Z.isDate=xh,Z.isElement=Qf,Z.isEmpty=Xf,Z.isEqual=nc,Z.isEqualWith=tc,Z.isError=rc,Z.isFinite=ec,Z.isFunction=uc,Z.isInteger=ic,Z.isLength=oc,Z.isMap=jh,
    	Z.isMatch=ac,Z.isMatchWith=lc,Z.isNaN=sc,Z.isNative=hc,Z.isNil=_c,Z.isNull=pc,Z.isNumber=vc,Z.isObject=fc,Z.isObjectLike=cc,Z.isPlainObject=gc,Z.isRegExp=Ah,Z.isSafeInteger=yc,Z.isSet=kh,Z.isString=dc,Z.isSymbol=bc,Z.isTypedArray=Oh,Z.isUndefined=wc,Z.isWeakMap=mc,Z.isWeakSet=xc,Z.join=xo,Z.kebabCase=Kh,Z.last=jo,Z.lastIndexOf=Ao,Z.lowerCase=Vh,Z.lowerFirst=Gh,Z.lt=Ih,Z.lte=Rh,Z.max=Ya,Z.maxBy=Qa,Z.mean=Xa,Z.meanBy=nl,Z.min=tl,Z.minBy=rl,Z.stubArray=Pa,Z.stubFalse=qa,Z.stubObject=Za,Z.stubString=Ka,
    	Z.stubTrue=Va,Z.multiply=_p,Z.nth=ko,Z.noConflict=$a,Z.noop=Da,Z.now=fh,Z.pad=ha,Z.padEnd=pa,Z.padStart=_a,Z.parseInt=va,Z.random=oa,Z.reduce=bf,Z.reduceRight=wf,Z.repeat=ga,Z.replace=ya,Z.result=Hc,Z.round=vp,Z.runInContext=p,Z.sample=xf,Z.size=kf,Z.snakeCase=Hh,Z.some=Of,Z.sortedIndex=Wo,Z.sortedIndexBy=Lo,Z.sortedIndexOf=Co,Z.sortedLastIndex=Uo,Z.sortedLastIndexBy=Bo,Z.sortedLastIndexOf=To,Z.startCase=Jh,Z.startsWith=ba,Z.subtract=gp,Z.sum=el,Z.sumBy=ul,Z.template=wa,Z.times=Ga,Z.toFinite=Ac,Z.toInteger=kc,
    	Z.toLength=Oc,Z.toLower=ma,Z.toNumber=Ic,Z.toSafeInteger=zc,Z.toString=Ec,Z.toUpper=xa,Z.trim=ja,Z.trimEnd=Aa,Z.trimStart=ka,Z.truncate=Oa,Z.unescape=Ia,Z.uniqueId=Ja,Z.upperCase=Yh,Z.upperFirst=Qh,Z.each=_f,Z.eachRight=vf,Z.first=bo,Ta(Z,function(){var n={};return ue(Z,function(t,r){bl.call(Z.prototype,r)||(n[r]=t);}),n}(),{chain:!1}),Z.VERSION=nn,r(["bind","bindKey","curry","curryRight","partial","partialRight"],function(n){Z[n].placeholder=Z;}),r(["drop","take"],function(n,t){Ct.prototype[n]=function(r){
    	r=r===X?1:Gl(kc(r),0);var e=this.__filtered__&&!t?new Ct(this):this.clone();return e.__filtered__?e.__takeCount__=Hl(r,e.__takeCount__):e.__views__.push({size:Hl(r,Un),type:n+(e.__dir__<0?"Right":"")}),e},Ct.prototype[n+"Right"]=function(t){return this.reverse()[n](t).reverse()};}),r(["filter","map","takeWhile"],function(n,t){var r=t+1,e=r==Rn||r==En;Ct.prototype[n]=function(n){var t=this.clone();return t.__iteratees__.push({iteratee:mi(n,3),type:r}),t.__filtered__=t.__filtered__||e,t};}),r(["head","last"],function(n,t){
    	var r="take"+(t?"Right":"");Ct.prototype[n]=function(){return this[r](1).value()[0]};}),r(["initial","tail"],function(n,t){var r="drop"+(t?"":"Right");Ct.prototype[n]=function(){return this.__filtered__?new Ct(this):this[r](1)};}),Ct.prototype.compact=function(){return this.filter(La)},Ct.prototype.find=function(n){return this.filter(n).head()},Ct.prototype.findLast=function(n){return this.reverse().find(n)},Ct.prototype.invokeMap=uu(function(n,t){return "function"==typeof n?new Ct(this):this.map(function(r){
    	return Ie(r,n,t)})}),Ct.prototype.reject=function(n){return this.filter(Uf(mi(n)))},Ct.prototype.slice=function(n,t){n=kc(n);var r=this;return r.__filtered__&&(n>0||t<0)?new Ct(r):(n<0?r=r.takeRight(-n):n&&(r=r.drop(n)),t!==X&&(t=kc(t),r=t<0?r.dropRight(-t):r.take(t-n)),r)},Ct.prototype.takeRightWhile=function(n){return this.reverse().takeWhile(n).reverse()},Ct.prototype.toArray=function(){return this.take(Un)},ue(Ct.prototype,function(n,t){var r=/^(?:filter|find|map|reject)|While$/.test(t),e=/^(?:head|last)$/.test(t),u=Z[e?"take"+("last"==t?"Right":""):t],i=e||/^find/.test(t);
    	u&&(Z.prototype[t]=function(){var t=this.__wrapped__,o=e?[1]:arguments,f=t instanceof Ct,c=o[0],l=f||bh(t),s=function(n){var t=u.apply(Z,a([n],o));return e&&h?t[0]:t};l&&r&&"function"==typeof c&&1!=c.length&&(f=l=!1);var h=this.__chain__,p=!!this.__actions__.length,_=i&&!h,v=f&&!p;if(!i&&l){t=v?t:new Ct(this);var g=n.apply(t,o);return g.__actions__.push({func:nf,args:[s],thisArg:X}),new Y(g,h)}return _&&v?n.apply(this,o):(g=this.thru(s),_?e?g.value()[0]:g.value():g)});}),r(["pop","push","shift","sort","splice","unshift"],function(n){
    	var t=_l[n],r=/^(?:push|sort|unshift)$/.test(n)?"tap":"thru",e=/^(?:pop|shift)$/.test(n);Z.prototype[n]=function(){var n=arguments;if(e&&!this.__chain__){var u=this.value();return t.apply(bh(u)?u:[],n)}return this[r](function(r){return t.apply(bh(r)?r:[],n)})};}),ue(Ct.prototype,function(n,t){var r=Z[t];if(r){var e=r.name+"";bl.call(fs,e)||(fs[e]=[]),fs[e].push({name:t,func:r});}}),fs[Qu(X,vn).name]=[{name:"wrapper",func:X}],Ct.prototype.clone=$t,Ct.prototype.reverse=Yt,Ct.prototype.value=Qt,Z.prototype.at=Qs,
    	Z.prototype.chain=tf,Z.prototype.commit=rf,Z.prototype.next=ef,Z.prototype.plant=of,Z.prototype.reverse=ff,Z.prototype.toJSON=Z.prototype.valueOf=Z.prototype.value=cf,Z.prototype.first=Z.prototype.head,Ul&&(Z.prototype[Ul]=uf),Z},be=de();ue?((ue.exports=be)._=be,ee._=be):re._=be;}).call(commonjsGlobal);
    } (lodash_min, lodash_minExports));

    var _mapping = {};

    /** Used to map aliases to their real names. */

    (function (exports) {
    	exports.aliasToReal = {

    	  // Lodash aliases.
    	  'each': 'forEach',
    	  'eachRight': 'forEachRight',
    	  'entries': 'toPairs',
    	  'entriesIn': 'toPairsIn',
    	  'extend': 'assignIn',
    	  'extendAll': 'assignInAll',
    	  'extendAllWith': 'assignInAllWith',
    	  'extendWith': 'assignInWith',
    	  'first': 'head',

    	  // Methods that are curried variants of others.
    	  'conforms': 'conformsTo',
    	  'matches': 'isMatch',
    	  'property': 'get',

    	  // Ramda aliases.
    	  '__': 'placeholder',
    	  'F': 'stubFalse',
    	  'T': 'stubTrue',
    	  'all': 'every',
    	  'allPass': 'overEvery',
    	  'always': 'constant',
    	  'any': 'some',
    	  'anyPass': 'overSome',
    	  'apply': 'spread',
    	  'assoc': 'set',
    	  'assocPath': 'set',
    	  'complement': 'negate',
    	  'compose': 'flowRight',
    	  'contains': 'includes',
    	  'dissoc': 'unset',
    	  'dissocPath': 'unset',
    	  'dropLast': 'dropRight',
    	  'dropLastWhile': 'dropRightWhile',
    	  'equals': 'isEqual',
    	  'identical': 'eq',
    	  'indexBy': 'keyBy',
    	  'init': 'initial',
    	  'invertObj': 'invert',
    	  'juxt': 'over',
    	  'omitAll': 'omit',
    	  'nAry': 'ary',
    	  'path': 'get',
    	  'pathEq': 'matchesProperty',
    	  'pathOr': 'getOr',
    	  'paths': 'at',
    	  'pickAll': 'pick',
    	  'pipe': 'flow',
    	  'pluck': 'map',
    	  'prop': 'get',
    	  'propEq': 'matchesProperty',
    	  'propOr': 'getOr',
    	  'props': 'at',
    	  'symmetricDifference': 'xor',
    	  'symmetricDifferenceBy': 'xorBy',
    	  'symmetricDifferenceWith': 'xorWith',
    	  'takeLast': 'takeRight',
    	  'takeLastWhile': 'takeRightWhile',
    	  'unapply': 'rest',
    	  'unnest': 'flatten',
    	  'useWith': 'overArgs',
    	  'where': 'conformsTo',
    	  'whereEq': 'isMatch',
    	  'zipObj': 'zipObject'
    	};

    	/** Used to map ary to method names. */
    	exports.aryMethod = {
    	  '1': [
    	    'assignAll', 'assignInAll', 'attempt', 'castArray', 'ceil', 'create',
    	    'curry', 'curryRight', 'defaultsAll', 'defaultsDeepAll', 'floor', 'flow',
    	    'flowRight', 'fromPairs', 'invert', 'iteratee', 'memoize', 'method', 'mergeAll',
    	    'methodOf', 'mixin', 'nthArg', 'over', 'overEvery', 'overSome','rest', 'reverse',
    	    'round', 'runInContext', 'spread', 'template', 'trim', 'trimEnd', 'trimStart',
    	    'uniqueId', 'words', 'zipAll'
    	  ],
    	  '2': [
    	    'add', 'after', 'ary', 'assign', 'assignAllWith', 'assignIn', 'assignInAllWith',
    	    'at', 'before', 'bind', 'bindAll', 'bindKey', 'chunk', 'cloneDeepWith',
    	    'cloneWith', 'concat', 'conformsTo', 'countBy', 'curryN', 'curryRightN',
    	    'debounce', 'defaults', 'defaultsDeep', 'defaultTo', 'delay', 'difference',
    	    'divide', 'drop', 'dropRight', 'dropRightWhile', 'dropWhile', 'endsWith', 'eq',
    	    'every', 'filter', 'find', 'findIndex', 'findKey', 'findLast', 'findLastIndex',
    	    'findLastKey', 'flatMap', 'flatMapDeep', 'flattenDepth', 'forEach',
    	    'forEachRight', 'forIn', 'forInRight', 'forOwn', 'forOwnRight', 'get',
    	    'groupBy', 'gt', 'gte', 'has', 'hasIn', 'includes', 'indexOf', 'intersection',
    	    'invertBy', 'invoke', 'invokeMap', 'isEqual', 'isMatch', 'join', 'keyBy',
    	    'lastIndexOf', 'lt', 'lte', 'map', 'mapKeys', 'mapValues', 'matchesProperty',
    	    'maxBy', 'meanBy', 'merge', 'mergeAllWith', 'minBy', 'multiply', 'nth', 'omit',
    	    'omitBy', 'overArgs', 'pad', 'padEnd', 'padStart', 'parseInt', 'partial',
    	    'partialRight', 'partition', 'pick', 'pickBy', 'propertyOf', 'pull', 'pullAll',
    	    'pullAt', 'random', 'range', 'rangeRight', 'rearg', 'reject', 'remove',
    	    'repeat', 'restFrom', 'result', 'sampleSize', 'some', 'sortBy', 'sortedIndex',
    	    'sortedIndexOf', 'sortedLastIndex', 'sortedLastIndexOf', 'sortedUniqBy',
    	    'split', 'spreadFrom', 'startsWith', 'subtract', 'sumBy', 'take', 'takeRight',
    	    'takeRightWhile', 'takeWhile', 'tap', 'throttle', 'thru', 'times', 'trimChars',
    	    'trimCharsEnd', 'trimCharsStart', 'truncate', 'union', 'uniqBy', 'uniqWith',
    	    'unset', 'unzipWith', 'without', 'wrap', 'xor', 'zip', 'zipObject',
    	    'zipObjectDeep'
    	  ],
    	  '3': [
    	    'assignInWith', 'assignWith', 'clamp', 'differenceBy', 'differenceWith',
    	    'findFrom', 'findIndexFrom', 'findLastFrom', 'findLastIndexFrom', 'getOr',
    	    'includesFrom', 'indexOfFrom', 'inRange', 'intersectionBy', 'intersectionWith',
    	    'invokeArgs', 'invokeArgsMap', 'isEqualWith', 'isMatchWith', 'flatMapDepth',
    	    'lastIndexOfFrom', 'mergeWith', 'orderBy', 'padChars', 'padCharsEnd',
    	    'padCharsStart', 'pullAllBy', 'pullAllWith', 'rangeStep', 'rangeStepRight',
    	    'reduce', 'reduceRight', 'replace', 'set', 'slice', 'sortedIndexBy',
    	    'sortedLastIndexBy', 'transform', 'unionBy', 'unionWith', 'update', 'xorBy',
    	    'xorWith', 'zipWith'
    	  ],
    	  '4': [
    	    'fill', 'setWith', 'updateWith'
    	  ]
    	};

    	/** Used to map ary to rearg configs. */
    	exports.aryRearg = {
    	  '2': [1, 0],
    	  '3': [2, 0, 1],
    	  '4': [3, 2, 0, 1]
    	};

    	/** Used to map method names to their iteratee ary. */
    	exports.iterateeAry = {
    	  'dropRightWhile': 1,
    	  'dropWhile': 1,
    	  'every': 1,
    	  'filter': 1,
    	  'find': 1,
    	  'findFrom': 1,
    	  'findIndex': 1,
    	  'findIndexFrom': 1,
    	  'findKey': 1,
    	  'findLast': 1,
    	  'findLastFrom': 1,
    	  'findLastIndex': 1,
    	  'findLastIndexFrom': 1,
    	  'findLastKey': 1,
    	  'flatMap': 1,
    	  'flatMapDeep': 1,
    	  'flatMapDepth': 1,
    	  'forEach': 1,
    	  'forEachRight': 1,
    	  'forIn': 1,
    	  'forInRight': 1,
    	  'forOwn': 1,
    	  'forOwnRight': 1,
    	  'map': 1,
    	  'mapKeys': 1,
    	  'mapValues': 1,
    	  'partition': 1,
    	  'reduce': 2,
    	  'reduceRight': 2,
    	  'reject': 1,
    	  'remove': 1,
    	  'some': 1,
    	  'takeRightWhile': 1,
    	  'takeWhile': 1,
    	  'times': 1,
    	  'transform': 2
    	};

    	/** Used to map method names to iteratee rearg configs. */
    	exports.iterateeRearg = {
    	  'mapKeys': [1],
    	  'reduceRight': [1, 0]
    	};

    	/** Used to map method names to rearg configs. */
    	exports.methodRearg = {
    	  'assignInAllWith': [1, 0],
    	  'assignInWith': [1, 2, 0],
    	  'assignAllWith': [1, 0],
    	  'assignWith': [1, 2, 0],
    	  'differenceBy': [1, 2, 0],
    	  'differenceWith': [1, 2, 0],
    	  'getOr': [2, 1, 0],
    	  'intersectionBy': [1, 2, 0],
    	  'intersectionWith': [1, 2, 0],
    	  'isEqualWith': [1, 2, 0],
    	  'isMatchWith': [2, 1, 0],
    	  'mergeAllWith': [1, 0],
    	  'mergeWith': [1, 2, 0],
    	  'padChars': [2, 1, 0],
    	  'padCharsEnd': [2, 1, 0],
    	  'padCharsStart': [2, 1, 0],
    	  'pullAllBy': [2, 1, 0],
    	  'pullAllWith': [2, 1, 0],
    	  'rangeStep': [1, 2, 0],
    	  'rangeStepRight': [1, 2, 0],
    	  'setWith': [3, 1, 2, 0],
    	  'sortedIndexBy': [2, 1, 0],
    	  'sortedLastIndexBy': [2, 1, 0],
    	  'unionBy': [1, 2, 0],
    	  'unionWith': [1, 2, 0],
    	  'updateWith': [3, 1, 2, 0],
    	  'xorBy': [1, 2, 0],
    	  'xorWith': [1, 2, 0],
    	  'zipWith': [1, 2, 0]
    	};

    	/** Used to map method names to spread configs. */
    	exports.methodSpread = {
    	  'assignAll': { 'start': 0 },
    	  'assignAllWith': { 'start': 0 },
    	  'assignInAll': { 'start': 0 },
    	  'assignInAllWith': { 'start': 0 },
    	  'defaultsAll': { 'start': 0 },
    	  'defaultsDeepAll': { 'start': 0 },
    	  'invokeArgs': { 'start': 2 },
    	  'invokeArgsMap': { 'start': 2 },
    	  'mergeAll': { 'start': 0 },
    	  'mergeAllWith': { 'start': 0 },
    	  'partial': { 'start': 1 },
    	  'partialRight': { 'start': 1 },
    	  'without': { 'start': 1 },
    	  'zipAll': { 'start': 0 }
    	};

    	/** Used to identify methods which mutate arrays or objects. */
    	exports.mutate = {
    	  'array': {
    	    'fill': true,
    	    'pull': true,
    	    'pullAll': true,
    	    'pullAllBy': true,
    	    'pullAllWith': true,
    	    'pullAt': true,
    	    'remove': true,
    	    'reverse': true
    	  },
    	  'object': {
    	    'assign': true,
    	    'assignAll': true,
    	    'assignAllWith': true,
    	    'assignIn': true,
    	    'assignInAll': true,
    	    'assignInAllWith': true,
    	    'assignInWith': true,
    	    'assignWith': true,
    	    'defaults': true,
    	    'defaultsAll': true,
    	    'defaultsDeep': true,
    	    'defaultsDeepAll': true,
    	    'merge': true,
    	    'mergeAll': true,
    	    'mergeAllWith': true,
    	    'mergeWith': true,
    	  },
    	  'set': {
    	    'set': true,
    	    'setWith': true,
    	    'unset': true,
    	    'update': true,
    	    'updateWith': true
    	  }
    	};

    	/** Used to map real names to their aliases. */
    	exports.realToAlias = (function() {
    	  var hasOwnProperty = Object.prototype.hasOwnProperty,
    	      object = exports.aliasToReal,
    	      result = {};

    	  for (var key in object) {
    	    var value = object[key];
    	    if (hasOwnProperty.call(result, value)) {
    	      result[value].push(key);
    	    } else {
    	      result[value] = [key];
    	    }
    	  }
    	  return result;
    	}());

    	/** Used to map method names to other names. */
    	exports.remap = {
    	  'assignAll': 'assign',
    	  'assignAllWith': 'assignWith',
    	  'assignInAll': 'assignIn',
    	  'assignInAllWith': 'assignInWith',
    	  'curryN': 'curry',
    	  'curryRightN': 'curryRight',
    	  'defaultsAll': 'defaults',
    	  'defaultsDeepAll': 'defaultsDeep',
    	  'findFrom': 'find',
    	  'findIndexFrom': 'findIndex',
    	  'findLastFrom': 'findLast',
    	  'findLastIndexFrom': 'findLastIndex',
    	  'getOr': 'get',
    	  'includesFrom': 'includes',
    	  'indexOfFrom': 'indexOf',
    	  'invokeArgs': 'invoke',
    	  'invokeArgsMap': 'invokeMap',
    	  'lastIndexOfFrom': 'lastIndexOf',
    	  'mergeAll': 'merge',
    	  'mergeAllWith': 'mergeWith',
    	  'padChars': 'pad',
    	  'padCharsEnd': 'padEnd',
    	  'padCharsStart': 'padStart',
    	  'propertyOf': 'get',
    	  'rangeStep': 'range',
    	  'rangeStepRight': 'rangeRight',
    	  'restFrom': 'rest',
    	  'spreadFrom': 'spread',
    	  'trimChars': 'trim',
    	  'trimCharsEnd': 'trimEnd',
    	  'trimCharsStart': 'trimStart',
    	  'zipAll': 'zip'
    	};

    	/** Used to track methods that skip fixing their arity. */
    	exports.skipFixed = {
    	  'castArray': true,
    	  'flow': true,
    	  'flowRight': true,
    	  'iteratee': true,
    	  'mixin': true,
    	  'rearg': true,
    	  'runInContext': true
    	};

    	/** Used to track methods that skip rearranging arguments. */
    	exports.skipRearg = {
    	  'add': true,
    	  'assign': true,
    	  'assignIn': true,
    	  'bind': true,
    	  'bindKey': true,
    	  'concat': true,
    	  'difference': true,
    	  'divide': true,
    	  'eq': true,
    	  'gt': true,
    	  'gte': true,
    	  'isEqual': true,
    	  'lt': true,
    	  'lte': true,
    	  'matchesProperty': true,
    	  'merge': true,
    	  'multiply': true,
    	  'overArgs': true,
    	  'partial': true,
    	  'partialRight': true,
    	  'propertyOf': true,
    	  'random': true,
    	  'range': true,
    	  'rangeRight': true,
    	  'subtract': true,
    	  'zip': true,
    	  'zipObject': true,
    	  'zipObjectDeep': true
    	};
    } (_mapping));

    /**
     * The default argument placeholder value for methods.
     *
     * @type {Object}
     */

    var placeholder = {};

    var mapping = _mapping,
        fallbackHolder = placeholder;

    /** Built-in value reference. */
    var push = Array.prototype.push;

    /**
     * Creates a function, with an arity of `n`, that invokes `func` with the
     * arguments it receives.
     *
     * @private
     * @param {Function} func The function to wrap.
     * @param {number} n The arity of the new function.
     * @returns {Function} Returns the new function.
     */
    function baseArity(func, n) {
      return n == 2
        ? function(a, b) { return func.apply(undefined, arguments); }
        : function(a) { return func.apply(undefined, arguments); };
    }

    /**
     * Creates a function that invokes `func`, with up to `n` arguments, ignoring
     * any additional arguments.
     *
     * @private
     * @param {Function} func The function to cap arguments for.
     * @param {number} n The arity cap.
     * @returns {Function} Returns the new function.
     */
    function baseAry(func, n) {
      return n == 2
        ? function(a, b) { return func(a, b); }
        : function(a) { return func(a); };
    }

    /**
     * Creates a clone of `array`.
     *
     * @private
     * @param {Array} array The array to clone.
     * @returns {Array} Returns the cloned array.
     */
    function cloneArray(array) {
      var length = array ? array.length : 0,
          result = Array(length);

      while (length--) {
        result[length] = array[length];
      }
      return result;
    }

    /**
     * Creates a function that clones a given object using the assignment `func`.
     *
     * @private
     * @param {Function} func The assignment function.
     * @returns {Function} Returns the new cloner function.
     */
    function createCloner(func) {
      return function(object) {
        return func({}, object);
      };
    }

    /**
     * A specialized version of `_.spread` which flattens the spread array into
     * the arguments of the invoked `func`.
     *
     * @private
     * @param {Function} func The function to spread arguments over.
     * @param {number} start The start position of the spread.
     * @returns {Function} Returns the new function.
     */
    function flatSpread(func, start) {
      return function() {
        var length = arguments.length,
            lastIndex = length - 1,
            args = Array(length);

        while (length--) {
          args[length] = arguments[length];
        }
        var array = args[start],
            otherArgs = args.slice(0, start);

        if (array) {
          push.apply(otherArgs, array);
        }
        if (start != lastIndex) {
          push.apply(otherArgs, args.slice(start + 1));
        }
        return func.apply(this, otherArgs);
      };
    }

    /**
     * Creates a function that wraps `func` and uses `cloner` to clone the first
     * argument it receives.
     *
     * @private
     * @param {Function} func The function to wrap.
     * @param {Function} cloner The function to clone arguments.
     * @returns {Function} Returns the new immutable function.
     */
    function wrapImmutable(func, cloner) {
      return function() {
        var length = arguments.length;
        if (!length) {
          return;
        }
        var args = Array(length);
        while (length--) {
          args[length] = arguments[length];
        }
        var result = args[0] = cloner.apply(undefined, args);
        func.apply(undefined, args);
        return result;
      };
    }

    /**
     * The base implementation of `convert` which accepts a `util` object of methods
     * required to perform conversions.
     *
     * @param {Object} util The util object.
     * @param {string} name The name of the function to convert.
     * @param {Function} func The function to convert.
     * @param {Object} [options] The options object.
     * @param {boolean} [options.cap=true] Specify capping iteratee arguments.
     * @param {boolean} [options.curry=true] Specify currying.
     * @param {boolean} [options.fixed=true] Specify fixed arity.
     * @param {boolean} [options.immutable=true] Specify immutable operations.
     * @param {boolean} [options.rearg=true] Specify rearranging arguments.
     * @returns {Function|Object} Returns the converted function or object.
     */
    function baseConvert(util, name, func, options) {
      var isLib = typeof name == 'function',
          isObj = name === Object(name);

      if (isObj) {
        options = func;
        func = name;
        name = undefined;
      }
      if (func == null) {
        throw new TypeError;
      }
      options || (options = {});

      var config = {
        'cap': 'cap' in options ? options.cap : true,
        'curry': 'curry' in options ? options.curry : true,
        'fixed': 'fixed' in options ? options.fixed : true,
        'immutable': 'immutable' in options ? options.immutable : true,
        'rearg': 'rearg' in options ? options.rearg : true
      };

      var defaultHolder = isLib ? func : fallbackHolder,
          forceCurry = ('curry' in options) && options.curry,
          forceFixed = ('fixed' in options) && options.fixed,
          forceRearg = ('rearg' in options) && options.rearg,
          pristine = isLib ? func.runInContext() : undefined;

      var helpers = isLib ? func : {
        'ary': util.ary,
        'assign': util.assign,
        'clone': util.clone,
        'curry': util.curry,
        'forEach': util.forEach,
        'isArray': util.isArray,
        'isError': util.isError,
        'isFunction': util.isFunction,
        'isWeakMap': util.isWeakMap,
        'iteratee': util.iteratee,
        'keys': util.keys,
        'rearg': util.rearg,
        'toInteger': util.toInteger,
        'toPath': util.toPath
      };

      var ary = helpers.ary,
          assign = helpers.assign,
          clone = helpers.clone,
          curry = helpers.curry,
          each = helpers.forEach,
          isArray = helpers.isArray,
          isError = helpers.isError,
          isFunction = helpers.isFunction,
          isWeakMap = helpers.isWeakMap,
          keys = helpers.keys,
          rearg = helpers.rearg,
          toInteger = helpers.toInteger,
          toPath = helpers.toPath;

      var aryMethodKeys = keys(mapping.aryMethod);

      var wrappers = {
        'castArray': function(castArray) {
          return function() {
            var value = arguments[0];
            return isArray(value)
              ? castArray(cloneArray(value))
              : castArray.apply(undefined, arguments);
          };
        },
        'iteratee': function(iteratee) {
          return function() {
            var func = arguments[0],
                arity = arguments[1],
                result = iteratee(func, arity),
                length = result.length;

            if (config.cap && typeof arity == 'number') {
              arity = arity > 2 ? (arity - 2) : 1;
              return (length && length <= arity) ? result : baseAry(result, arity);
            }
            return result;
          };
        },
        'mixin': function(mixin) {
          return function(source) {
            var func = this;
            if (!isFunction(func)) {
              return mixin(func, Object(source));
            }
            var pairs = [];
            each(keys(source), function(key) {
              if (isFunction(source[key])) {
                pairs.push([key, func.prototype[key]]);
              }
            });

            mixin(func, Object(source));

            each(pairs, function(pair) {
              var value = pair[1];
              if (isFunction(value)) {
                func.prototype[pair[0]] = value;
              } else {
                delete func.prototype[pair[0]];
              }
            });
            return func;
          };
        },
        'nthArg': function(nthArg) {
          return function(n) {
            var arity = n < 0 ? 1 : (toInteger(n) + 1);
            return curry(nthArg(n), arity);
          };
        },
        'rearg': function(rearg) {
          return function(func, indexes) {
            var arity = indexes ? indexes.length : 0;
            return curry(rearg(func, indexes), arity);
          };
        },
        'runInContext': function(runInContext) {
          return function(context) {
            return baseConvert(util, runInContext(context), options);
          };
        }
      };

      /*--------------------------------------------------------------------------*/

      /**
       * Casts `func` to a function with an arity capped iteratee if needed.
       *
       * @private
       * @param {string} name The name of the function to inspect.
       * @param {Function} func The function to inspect.
       * @returns {Function} Returns the cast function.
       */
      function castCap(name, func) {
        if (config.cap) {
          var indexes = mapping.iterateeRearg[name];
          if (indexes) {
            return iterateeRearg(func, indexes);
          }
          var n = !isLib && mapping.iterateeAry[name];
          if (n) {
            return iterateeAry(func, n);
          }
        }
        return func;
      }

      /**
       * Casts `func` to a curried function if needed.
       *
       * @private
       * @param {string} name The name of the function to inspect.
       * @param {Function} func The function to inspect.
       * @param {number} n The arity of `func`.
       * @returns {Function} Returns the cast function.
       */
      function castCurry(name, func, n) {
        return (forceCurry || (config.curry && n > 1))
          ? curry(func, n)
          : func;
      }

      /**
       * Casts `func` to a fixed arity function if needed.
       *
       * @private
       * @param {string} name The name of the function to inspect.
       * @param {Function} func The function to inspect.
       * @param {number} n The arity cap.
       * @returns {Function} Returns the cast function.
       */
      function castFixed(name, func, n) {
        if (config.fixed && (forceFixed || !mapping.skipFixed[name])) {
          var data = mapping.methodSpread[name],
              start = data && data.start;

          return start  === undefined ? ary(func, n) : flatSpread(func, start);
        }
        return func;
      }

      /**
       * Casts `func` to an rearged function if needed.
       *
       * @private
       * @param {string} name The name of the function to inspect.
       * @param {Function} func The function to inspect.
       * @param {number} n The arity of `func`.
       * @returns {Function} Returns the cast function.
       */
      function castRearg(name, func, n) {
        return (config.rearg && n > 1 && (forceRearg || !mapping.skipRearg[name]))
          ? rearg(func, mapping.methodRearg[name] || mapping.aryRearg[n])
          : func;
      }

      /**
       * Creates a clone of `object` by `path`.
       *
       * @private
       * @param {Object} object The object to clone.
       * @param {Array|string} path The path to clone by.
       * @returns {Object} Returns the cloned object.
       */
      function cloneByPath(object, path) {
        path = toPath(path);

        var index = -1,
            length = path.length,
            lastIndex = length - 1,
            result = clone(Object(object)),
            nested = result;

        while (nested != null && ++index < length) {
          var key = path[index],
              value = nested[key];

          if (value != null &&
              !(isFunction(value) || isError(value) || isWeakMap(value))) {
            nested[key] = clone(index == lastIndex ? value : Object(value));
          }
          nested = nested[key];
        }
        return result;
      }

      /**
       * Converts `lodash` to an immutable auto-curried iteratee-first data-last
       * version with conversion `options` applied.
       *
       * @param {Object} [options] The options object. See `baseConvert` for more details.
       * @returns {Function} Returns the converted `lodash`.
       */
      function convertLib(options) {
        return _.runInContext.convert(options)(undefined);
      }

      /**
       * Create a converter function for `func` of `name`.
       *
       * @param {string} name The name of the function to convert.
       * @param {Function} func The function to convert.
       * @returns {Function} Returns the new converter function.
       */
      function createConverter(name, func) {
        var realName = mapping.aliasToReal[name] || name,
            methodName = mapping.remap[realName] || realName,
            oldOptions = options;

        return function(options) {
          var newUtil = isLib ? pristine : helpers,
              newFunc = isLib ? pristine[methodName] : func,
              newOptions = assign(assign({}, oldOptions), options);

          return baseConvert(newUtil, realName, newFunc, newOptions);
        };
      }

      /**
       * Creates a function that wraps `func` to invoke its iteratee, with up to `n`
       * arguments, ignoring any additional arguments.
       *
       * @private
       * @param {Function} func The function to cap iteratee arguments for.
       * @param {number} n The arity cap.
       * @returns {Function} Returns the new function.
       */
      function iterateeAry(func, n) {
        return overArg(func, function(func) {
          return typeof func == 'function' ? baseAry(func, n) : func;
        });
      }

      /**
       * Creates a function that wraps `func` to invoke its iteratee with arguments
       * arranged according to the specified `indexes` where the argument value at
       * the first index is provided as the first argument, the argument value at
       * the second index is provided as the second argument, and so on.
       *
       * @private
       * @param {Function} func The function to rearrange iteratee arguments for.
       * @param {number[]} indexes The arranged argument indexes.
       * @returns {Function} Returns the new function.
       */
      function iterateeRearg(func, indexes) {
        return overArg(func, function(func) {
          var n = indexes.length;
          return baseArity(rearg(baseAry(func, n), indexes), n);
        });
      }

      /**
       * Creates a function that invokes `func` with its first argument transformed.
       *
       * @private
       * @param {Function} func The function to wrap.
       * @param {Function} transform The argument transform.
       * @returns {Function} Returns the new function.
       */
      function overArg(func, transform) {
        return function() {
          var length = arguments.length;
          if (!length) {
            return func();
          }
          var args = Array(length);
          while (length--) {
            args[length] = arguments[length];
          }
          var index = config.rearg ? 0 : (length - 1);
          args[index] = transform(args[index]);
          return func.apply(undefined, args);
        };
      }

      /**
       * Creates a function that wraps `func` and applys the conversions
       * rules by `name`.
       *
       * @private
       * @param {string} name The name of the function to wrap.
       * @param {Function} func The function to wrap.
       * @returns {Function} Returns the converted function.
       */
      function wrap(name, func, placeholder) {
        var result,
            realName = mapping.aliasToReal[name] || name,
            wrapped = func,
            wrapper = wrappers[realName];

        if (wrapper) {
          wrapped = wrapper(func);
        }
        else if (config.immutable) {
          if (mapping.mutate.array[realName]) {
            wrapped = wrapImmutable(func, cloneArray);
          }
          else if (mapping.mutate.object[realName]) {
            wrapped = wrapImmutable(func, createCloner(func));
          }
          else if (mapping.mutate.set[realName]) {
            wrapped = wrapImmutable(func, cloneByPath);
          }
        }
        each(aryMethodKeys, function(aryKey) {
          each(mapping.aryMethod[aryKey], function(otherName) {
            if (realName == otherName) {
              var data = mapping.methodSpread[realName],
                  afterRearg = data && data.afterRearg;

              result = afterRearg
                ? castFixed(realName, castRearg(realName, wrapped, aryKey), aryKey)
                : castRearg(realName, castFixed(realName, wrapped, aryKey), aryKey);

              result = castCap(realName, result);
              result = castCurry(realName, result, aryKey);
              return false;
            }
          });
          return !result;
        });

        result || (result = wrapped);
        if (result == func) {
          result = forceCurry ? curry(result, 1) : function() {
            return func.apply(this, arguments);
          };
        }
        result.convert = createConverter(realName, func);
        result.placeholder = func.placeholder = placeholder;

        return result;
      }

      /*--------------------------------------------------------------------------*/

      if (!isObj) {
        return wrap(name, func, defaultHolder);
      }
      var _ = func;

      // Convert methods by ary cap.
      var pairs = [];
      each(aryMethodKeys, function(aryKey) {
        each(mapping.aryMethod[aryKey], function(key) {
          var func = _[mapping.remap[key] || key];
          if (func) {
            pairs.push([key, wrap(key, func, _)]);
          }
        });
      });

      // Convert remaining methods.
      each(keys(_), function(key) {
        var func = _[key];
        if (typeof func == 'function') {
          var length = pairs.length;
          while (length--) {
            if (pairs[length][0] == key) {
              return;
            }
          }
          func.convert = createConverter(key, func);
          pairs.push([key, func]);
        }
      });

      // Assign to `_` leaving `_.prototype` unchanged to allow chaining.
      each(pairs, function(pair) {
        _[pair[0]] = pair[1];
      });

      _.convert = convertLib;
      _.placeholder = _;

      // Assign aliases.
      each(keys(_), function(key) {
        each(mapping.realToAlias[key] || [], function(alias) {
          _[alias] = _[key];
        });
      });

      return _;
    }

    var _baseConvert = baseConvert;

    var _ = lodash_minExports.runInContext();
    var fp = _baseConvert(_, _);

    /** Used for built-in method references. */

    var objectProto = Object.prototype;

    /** Used to check objects for own properties. */
    var hasOwnProperty$1 = objectProto.hasOwnProperty;

    /**
     * The base implementation of `_.has` without support for deep paths.
     *
     * @private
     * @param {Object} [object] The object to query.
     * @param {Array|string} key The key to check.
     * @returns {boolean} Returns `true` if `key` exists, else `false`.
     */
    function baseHas$1(object, key) {
      return object != null && hasOwnProperty$1.call(object, key);
    }

    var _baseHas = baseHas$1;

    var baseHas = _baseHas,
        hasPath = _hasPath;

    /**
     * Checks if `path` is a direct property of `object`.
     *
     * @static
     * @since 0.1.0
     * @memberOf _
     * @category Object
     * @param {Object} object The object to query.
     * @param {Array|string} path The path to check.
     * @returns {boolean} Returns `true` if `path` exists, else `false`.
     * @example
     *
     * var object = { 'a': { 'b': 2 } };
     * var other = _.create({ 'a': _.create({ 'b': 2 }) });
     *
     * _.has(object, 'a');
     * // => true
     *
     * _.has(object, 'a.b');
     * // => true
     *
     * _.has(object, ['a', 'b']);
     * // => true
     *
     * _.has(other, 'a');
     * // => false
     */
    function has$1(object, path) {
      return object != null && hasPath(object, path, baseHas);
    }

    var has_1 = has$1;

    var baseSlice = _baseSlice;

    /**
     * Casts `array` to a slice if it's needed.
     *
     * @private
     * @param {Array} array The array to inspect.
     * @param {number} start The start position.
     * @param {number} [end=array.length] The end position.
     * @returns {Array} Returns the cast slice.
     */
    function castSlice$1(array, start, end) {
      var length = array.length;
      end = end === undefined ? length : end;
      return (!start && end >= length) ? array : baseSlice(array, start, end);
    }

    var _castSlice = castSlice$1;

    var baseGetTag = _baseGetTag,
        isObjectLike = isObjectLike_1;

    /** `Object#toString` result references. */
    var regexpTag = '[object RegExp]';

    /**
     * The base implementation of `_.isRegExp` without Node.js optimizations.
     *
     * @private
     * @param {*} value The value to check.
     * @returns {boolean} Returns `true` if `value` is a regexp, else `false`.
     */
    function baseIsRegExp$1(value) {
      return isObjectLike(value) && baseGetTag(value) == regexpTag;
    }

    var _baseIsRegExp = baseIsRegExp$1;

    var baseIsRegExp = _baseIsRegExp,
        baseUnary = _baseUnary,
        nodeUtil = _nodeUtilExports;

    /* Node.js helper references. */
    var nodeIsRegExp = nodeUtil && nodeUtil.isRegExp;

    /**
     * Checks if `value` is classified as a `RegExp` object.
     *
     * @static
     * @memberOf _
     * @since 0.1.0
     * @category Lang
     * @param {*} value The value to check.
     * @returns {boolean} Returns `true` if `value` is a regexp, else `false`.
     * @example
     *
     * _.isRegExp(/abc/);
     * // => true
     *
     * _.isRegExp('/abc/');
     * // => false
     */
    var isRegExp$1 = nodeIsRegExp ? baseUnary(nodeIsRegExp) : baseIsRegExp;

    var isRegExp_1 = isRegExp$1;

    /**
     * Converts an ASCII `string` to an array.
     *
     * @private
     * @param {string} string The string to convert.
     * @returns {Array} Returns the converted array.
     */

    function asciiToArray$1(string) {
      return string.split('');
    }

    var _asciiToArray = asciiToArray$1;

    /** Used to compose unicode character classes. */

    var rsAstralRange = '\\ud800-\\udfff',
        rsComboMarksRange = '\\u0300-\\u036f',
        reComboHalfMarksRange = '\\ufe20-\\ufe2f',
        rsComboSymbolsRange = '\\u20d0-\\u20ff',
        rsComboRange = rsComboMarksRange + reComboHalfMarksRange + rsComboSymbolsRange,
        rsVarRange = '\\ufe0e\\ufe0f';

    /** Used to compose unicode capture groups. */
    var rsAstral = '[' + rsAstralRange + ']',
        rsCombo = '[' + rsComboRange + ']',
        rsFitz = '\\ud83c[\\udffb-\\udfff]',
        rsModifier = '(?:' + rsCombo + '|' + rsFitz + ')',
        rsNonAstral = '[^' + rsAstralRange + ']',
        rsRegional = '(?:\\ud83c[\\udde6-\\uddff]){2}',
        rsSurrPair = '[\\ud800-\\udbff][\\udc00-\\udfff]',
        rsZWJ = '\\u200d';

    /** Used to compose unicode regexes. */
    var reOptMod = rsModifier + '?',
        rsOptVar = '[' + rsVarRange + ']?',
        rsOptJoin = '(?:' + rsZWJ + '(?:' + [rsNonAstral, rsRegional, rsSurrPair].join('|') + ')' + rsOptVar + reOptMod + ')*',
        rsSeq = rsOptVar + reOptMod + rsOptJoin,
        rsSymbol = '(?:' + [rsNonAstral + rsCombo + '?', rsCombo, rsRegional, rsSurrPair, rsAstral].join('|') + ')';

    /** Used to match [string symbols](https://mathiasbynens.be/notes/javascript-unicode). */
    var reUnicode = RegExp(rsFitz + '(?=' + rsFitz + ')|' + rsSymbol + rsSeq, 'g');

    /**
     * Converts a Unicode `string` to an array.
     *
     * @private
     * @param {string} string The string to convert.
     * @returns {Array} Returns the converted array.
     */
    function unicodeToArray$1(string) {
      return string.match(reUnicode) || [];
    }

    var _unicodeToArray = unicodeToArray$1;

    var asciiToArray = _asciiToArray,
        hasUnicode$1 = _hasUnicode,
        unicodeToArray = _unicodeToArray;

    /**
     * Converts `string` to an array.
     *
     * @private
     * @param {string} string The string to convert.
     * @returns {Array} Returns the converted array.
     */
    function stringToArray$1(string) {
      return hasUnicode$1(string)
        ? unicodeToArray(string)
        : asciiToArray(string);
    }

    var _stringToArray = stringToArray$1;

    var baseToString = _baseToString,
        castSlice = _castSlice,
        hasUnicode = _hasUnicode,
        isObject$1 = isObject_1,
        isRegExp = isRegExp_1,
        stringSize = _stringSize,
        stringToArray = _stringToArray,
        toInteger = toInteger_1,
        toString$1 = toString_1;

    /** Used as default options for `_.truncate`. */
    var DEFAULT_TRUNC_LENGTH = 30,
        DEFAULT_TRUNC_OMISSION = '...';

    /** Used to match `RegExp` flags from their coerced string values. */
    var reFlags = /\w*$/;

    /**
     * Truncates `string` if it's longer than the given maximum string length.
     * The last characters of the truncated string are replaced with the omission
     * string which defaults to "...".
     *
     * @static
     * @memberOf _
     * @since 4.0.0
     * @category String
     * @param {string} [string=''] The string to truncate.
     * @param {Object} [options={}] The options object.
     * @param {number} [options.length=30] The maximum string length.
     * @param {string} [options.omission='...'] The string to indicate text is omitted.
     * @param {RegExp|string} [options.separator] The separator pattern to truncate to.
     * @returns {string} Returns the truncated string.
     * @example
     *
     * _.truncate('hi-diddly-ho there, neighborino');
     * // => 'hi-diddly-ho there, neighbo...'
     *
     * _.truncate('hi-diddly-ho there, neighborino', {
     *   'length': 24,
     *   'separator': ' '
     * });
     * // => 'hi-diddly-ho there,...'
     *
     * _.truncate('hi-diddly-ho there, neighborino', {
     *   'length': 24,
     *   'separator': /,? +/
     * });
     * // => 'hi-diddly-ho there...'
     *
     * _.truncate('hi-diddly-ho there, neighborino', {
     *   'omission': ' [...]'
     * });
     * // => 'hi-diddly-ho there, neig [...]'
     */
    function truncate(string, options) {
      var length = DEFAULT_TRUNC_LENGTH,
          omission = DEFAULT_TRUNC_OMISSION;

      if (isObject$1(options)) {
        var separator = 'separator' in options ? options.separator : separator;
        length = 'length' in options ? toInteger(options.length) : length;
        omission = 'omission' in options ? baseToString(options.omission) : omission;
      }
      string = toString$1(string);

      var strLength = string.length;
      if (hasUnicode(string)) {
        var strSymbols = stringToArray(string);
        strLength = strSymbols.length;
      }
      if (length >= strLength) {
        return string;
      }
      var end = length - stringSize(omission);
      if (end < 1) {
        return omission;
      }
      var result = strSymbols
        ? castSlice(strSymbols, 0, end).join('')
        : string.slice(0, end);

      if (separator === undefined) {
        return result + omission;
      }
      if (strSymbols) {
        end += (result.length - end);
      }
      if (isRegExp(separator)) {
        if (string.slice(end).search(separator)) {
          var match,
              substring = result;

          if (!separator.global) {
            separator = RegExp(separator.source, toString$1(reFlags.exec(separator)) + 'g');
          }
          separator.lastIndex = 0;
          while ((match = separator.exec(substring))) {
            var newEnd = match.index;
          }
          result = result.slice(0, newEnd === undefined ? end : newEnd);
        }
      } else if (string.indexOf(baseToString(separator), end) != end) {
        var index = result.lastIndexOf(separator);
        if (index > -1) {
          result = result.slice(0, index);
        }
      }
      return result + omission;
    }

    var truncate_1 = truncate;

    var libExports = {};
    var lib$1 = {
      get exports(){ return libExports; },
      set exports(v){ libExports = v; },
    };

    function createPubSub() {
        var subscribers = Object.create(null);
        var nextId = 0;
        function subscribe(subscriber) {
            var id = nextId++;
            subscribers[id] = subscriber;
            return function unsubscribe() {
                delete subscribers[id];
            };
        }
        function publish(event) {
            for (var id in subscribers) {
                subscribers[id](event);
            }
        }
        return {
            publish: publish,
            subscribe: subscribe,
        };
    }

    var esm = /*#__PURE__*/Object.freeze({
        __proto__: null,
        default: createPubSub
    });

    var require$$0 = /*@__PURE__*/getAugmentedNamespace(esm);

    var middlewareReducerExports = {};
    var middlewareReducer = {
      get exports(){ return middlewareReducerExports; },
      set exports(v){ middlewareReducerExports = v; },
    };

    (function (module, exports) {

    	Object.defineProperty(exports, "__esModule", {
    	  value: true
    	});
    	exports.default = void 0;

    	var _default = function _default(middleware) {
    	  var applyMiddleware = function applyMiddleware(hook, defaultValue) {
    	    var bailEarly = hook === 'onError';
    	    var value = defaultValue;

    	    for (var _len = arguments.length, args = new Array(_len > 2 ? _len - 2 : 0), _key = 2; _key < _len; _key++) {
    	      args[_key - 2] = arguments[_key];
    	    }

    	    for (var i = 0; i < middleware[hook].length; i++) {
    	      var handler = middleware[hook][i];
    	      value = handler.apply(void 0, [value].concat(args));

    	      if (bailEarly && !value) {
    	        break;
    	      }
    	    }

    	    return value;
    	  };

    	  return applyMiddleware;
    	};

    	exports.default = _default;
    	module.exports = exports.default;
    	
    } (middlewareReducer, middlewareReducerExports));

    var defaultOptionsProcessorExports = {};
    var defaultOptionsProcessor = {
      get exports(){ return defaultOptionsProcessorExports; },
      set exports(v){ defaultOptionsProcessorExports = v; },
    };

    /**
     * Check if we're required to add a port number.
     *
     * @see https://url.spec.whatwg.org/#default-port
     * @param {Number|String} port Port number we need to check
     * @param {String} protocol Protocol we need to check against.
     * @returns {Boolean} Is it a default port for the given protocol
     * @api private
     */
    var requiresPort = function required(port, protocol) {
      protocol = protocol.split(':')[0];
      port = +port;

      if (!port) return false;

      switch (protocol) {
        case 'http':
        case 'ws':
        return port !== 80;

        case 'https':
        case 'wss':
        return port !== 443;

        case 'ftp':
        return port !== 21;

        case 'gopher':
        return port !== 70;

        case 'file':
        return false;
      }

      return port !== 0;
    };

    var querystringify$1 = {};

    var has = Object.prototype.hasOwnProperty
      , undef;

    /**
     * Decode a URI encoded string.
     *
     * @param {String} input The URI encoded string.
     * @returns {String|Null} The decoded string.
     * @api private
     */
    function decode(input) {
      try {
        return decodeURIComponent(input.replace(/\+/g, ' '));
      } catch (e) {
        return null;
      }
    }

    /**
     * Attempts to encode a given input.
     *
     * @param {String} input The string that needs to be encoded.
     * @returns {String|Null} The encoded string.
     * @api private
     */
    function encode(input) {
      try {
        return encodeURIComponent(input);
      } catch (e) {
        return null;
      }
    }

    /**
     * Simple query string parser.
     *
     * @param {String} query The query string that needs to be parsed.
     * @returns {Object}
     * @api public
     */
    function querystring(query) {
      var parser = /([^=?#&]+)=?([^&]*)/g
        , result = {}
        , part;

      while (part = parser.exec(query)) {
        var key = decode(part[1])
          , value = decode(part[2]);

        //
        // Prevent overriding of existing properties. This ensures that build-in
        // methods like `toString` or __proto__ are not overriden by malicious
        // querystrings.
        //
        // In the case if failed decoding, we want to omit the key/value pairs
        // from the result.
        //
        if (key === null || value === null || key in result) continue;
        result[key] = value;
      }

      return result;
    }

    /**
     * Transform a query string to an object.
     *
     * @param {Object} obj Object that should be transformed.
     * @param {String} prefix Optional prefix.
     * @returns {String}
     * @api public
     */
    function querystringify(obj, prefix) {
      prefix = prefix || '';

      var pairs = []
        , value
        , key;

      //
      // Optionally prefix with a '?' if needed
      //
      if ('string' !== typeof prefix) prefix = '?';

      for (key in obj) {
        if (has.call(obj, key)) {
          value = obj[key];

          //
          // Edge cases where we actually want to encode the value to an empty
          // string instead of the stringified value.
          //
          if (!value && (value === null || value === undef || isNaN(value))) {
            value = '';
          }

          key = encode(key);
          value = encode(value);

          //
          // If we failed to encode the strings, we should bail out as we don't
          // want to add invalid strings to the query.
          //
          if (key === null || value === null) continue;
          pairs.push(key +'='+ value);
        }
      }

      return pairs.length ? prefix + pairs.join('&') : '';
    }

    //
    // Expose the module.
    //
    querystringify$1.stringify = querystringify;
    querystringify$1.parse = querystring;

    var required = requiresPort
      , qs = querystringify$1
      , controlOrWhitespace = /^[\x00-\x20\u00a0\u1680\u2000-\u200a\u2028\u2029\u202f\u205f\u3000\ufeff]+/
      , CRHTLF = /[\n\r\t]/g
      , slashes = /^[A-Za-z][A-Za-z0-9+-.]*:\/\//
      , port = /:\d+$/
      , protocolre = /^([a-z][a-z0-9.+-]*:)?(\/\/)?([\\/]+)?([\S\s]*)/i
      , windowsDriveLetter = /^[a-zA-Z]:/;

    /**
     * Remove control characters and whitespace from the beginning of a string.
     *
     * @param {Object|String} str String to trim.
     * @returns {String} A new string representing `str` stripped of control
     *     characters and whitespace from its beginning.
     * @public
     */
    function trimLeft(str) {
      return (str ? str : '').toString().replace(controlOrWhitespace, '');
    }

    /**
     * These are the parse rules for the URL parser, it informs the parser
     * about:
     *
     * 0. The char it Needs to parse, if it's a string it should be done using
     *    indexOf, RegExp using exec and NaN means set as current value.
     * 1. The property we should set when parsing this value.
     * 2. Indication if it's backwards or forward parsing, when set as number it's
     *    the value of extra chars that should be split off.
     * 3. Inherit from location if non existing in the parser.
     * 4. `toLowerCase` the resulting value.
     */
    var rules = [
      ['#', 'hash'],                        // Extract from the back.
      ['?', 'query'],                       // Extract from the back.
      function sanitize(address, url) {     // Sanitize what is left of the address
        return isSpecial(url.protocol) ? address.replace(/\\/g, '/') : address;
      },
      ['/', 'pathname'],                    // Extract from the back.
      ['@', 'auth', 1],                     // Extract from the front.
      [NaN, 'host', undefined, 1, 1],       // Set left over value.
      [/:(\d*)$/, 'port', undefined, 1],    // RegExp the back.
      [NaN, 'hostname', undefined, 1, 1]    // Set left over.
    ];

    /**
     * These properties should not be copied or inherited from. This is only needed
     * for all non blob URL's as a blob URL does not include a hash, only the
     * origin.
     *
     * @type {Object}
     * @private
     */
    var ignore = { hash: 1, query: 1 };

    /**
     * The location object differs when your code is loaded through a normal page,
     * Worker or through a worker using a blob. And with the blobble begins the
     * trouble as the location object will contain the URL of the blob, not the
     * location of the page where our code is loaded in. The actual origin is
     * encoded in the `pathname` so we can thankfully generate a good "default"
     * location from it so we can generate proper relative URL's again.
     *
     * @param {Object|String} loc Optional default location object.
     * @returns {Object} lolcation object.
     * @public
     */
    function lolcation(loc) {
      var globalVar;

      if (typeof window !== 'undefined') globalVar = window;
      else if (typeof commonjsGlobal !== 'undefined') globalVar = commonjsGlobal;
      else if (typeof self !== 'undefined') globalVar = self;
      else globalVar = {};

      var location = globalVar.location || {};
      loc = loc || location;

      var finaldestination = {}
        , type = typeof loc
        , key;

      if ('blob:' === loc.protocol) {
        finaldestination = new Url(unescape(loc.pathname), {});
      } else if ('string' === type) {
        finaldestination = new Url(loc, {});
        for (key in ignore) delete finaldestination[key];
      } else if ('object' === type) {
        for (key in loc) {
          if (key in ignore) continue;
          finaldestination[key] = loc[key];
        }

        if (finaldestination.slashes === undefined) {
          finaldestination.slashes = slashes.test(loc.href);
        }
      }

      return finaldestination;
    }

    /**
     * Check whether a protocol scheme is special.
     *
     * @param {String} The protocol scheme of the URL
     * @return {Boolean} `true` if the protocol scheme is special, else `false`
     * @private
     */
    function isSpecial(scheme) {
      return (
        scheme === 'file:' ||
        scheme === 'ftp:' ||
        scheme === 'http:' ||
        scheme === 'https:' ||
        scheme === 'ws:' ||
        scheme === 'wss:'
      );
    }

    /**
     * @typedef ProtocolExtract
     * @type Object
     * @property {String} protocol Protocol matched in the URL, in lowercase.
     * @property {Boolean} slashes `true` if protocol is followed by "//", else `false`.
     * @property {String} rest Rest of the URL that is not part of the protocol.
     */

    /**
     * Extract protocol information from a URL with/without double slash ("//").
     *
     * @param {String} address URL we want to extract from.
     * @param {Object} location
     * @return {ProtocolExtract} Extracted information.
     * @private
     */
    function extractProtocol(address, location) {
      address = trimLeft(address);
      address = address.replace(CRHTLF, '');
      location = location || {};

      var match = protocolre.exec(address);
      var protocol = match[1] ? match[1].toLowerCase() : '';
      var forwardSlashes = !!match[2];
      var otherSlashes = !!match[3];
      var slashesCount = 0;
      var rest;

      if (forwardSlashes) {
        if (otherSlashes) {
          rest = match[2] + match[3] + match[4];
          slashesCount = match[2].length + match[3].length;
        } else {
          rest = match[2] + match[4];
          slashesCount = match[2].length;
        }
      } else {
        if (otherSlashes) {
          rest = match[3] + match[4];
          slashesCount = match[3].length;
        } else {
          rest = match[4];
        }
      }

      if (protocol === 'file:') {
        if (slashesCount >= 2) {
          rest = rest.slice(2);
        }
      } else if (isSpecial(protocol)) {
        rest = match[4];
      } else if (protocol) {
        if (forwardSlashes) {
          rest = rest.slice(2);
        }
      } else if (slashesCount >= 2 && isSpecial(location.protocol)) {
        rest = match[4];
      }

      return {
        protocol: protocol,
        slashes: forwardSlashes || isSpecial(protocol),
        slashesCount: slashesCount,
        rest: rest
      };
    }

    /**
     * Resolve a relative URL pathname against a base URL pathname.
     *
     * @param {String} relative Pathname of the relative URL.
     * @param {String} base Pathname of the base URL.
     * @return {String} Resolved pathname.
     * @private
     */
    function resolve(relative, base) {
      if (relative === '') return base;

      var path = (base || '/').split('/').slice(0, -1).concat(relative.split('/'))
        , i = path.length
        , last = path[i - 1]
        , unshift = false
        , up = 0;

      while (i--) {
        if (path[i] === '.') {
          path.splice(i, 1);
        } else if (path[i] === '..') {
          path.splice(i, 1);
          up++;
        } else if (up) {
          if (i === 0) unshift = true;
          path.splice(i, 1);
          up--;
        }
      }

      if (unshift) path.unshift('');
      if (last === '.' || last === '..') path.push('');

      return path.join('/');
    }

    /**
     * The actual URL instance. Instead of returning an object we've opted-in to
     * create an actual constructor as it's much more memory efficient and
     * faster and it pleases my OCD.
     *
     * It is worth noting that we should not use `URL` as class name to prevent
     * clashes with the global URL instance that got introduced in browsers.
     *
     * @constructor
     * @param {String} address URL we want to parse.
     * @param {Object|String} [location] Location defaults for relative paths.
     * @param {Boolean|Function} [parser] Parser for the query string.
     * @private
     */
    function Url(address, location, parser) {
      address = trimLeft(address);
      address = address.replace(CRHTLF, '');

      if (!(this instanceof Url)) {
        return new Url(address, location, parser);
      }

      var relative, extracted, parse, instruction, index, key
        , instructions = rules.slice()
        , type = typeof location
        , url = this
        , i = 0;

      //
      // The following if statements allows this module two have compatibility with
      // 2 different API:
      //
      // 1. Node.js's `url.parse` api which accepts a URL, boolean as arguments
      //    where the boolean indicates that the query string should also be parsed.
      //
      // 2. The `URL` interface of the browser which accepts a URL, object as
      //    arguments. The supplied object will be used as default values / fall-back
      //    for relative paths.
      //
      if ('object' !== type && 'string' !== type) {
        parser = location;
        location = null;
      }

      if (parser && 'function' !== typeof parser) parser = qs.parse;

      location = lolcation(location);

      //
      // Extract protocol information before running the instructions.
      //
      extracted = extractProtocol(address || '', location);
      relative = !extracted.protocol && !extracted.slashes;
      url.slashes = extracted.slashes || relative && location.slashes;
      url.protocol = extracted.protocol || location.protocol || '';
      address = extracted.rest;

      //
      // When the authority component is absent the URL starts with a path
      // component.
      //
      if (
        extracted.protocol === 'file:' && (
          extracted.slashesCount !== 2 || windowsDriveLetter.test(address)) ||
        (!extracted.slashes &&
          (extracted.protocol ||
            extracted.slashesCount < 2 ||
            !isSpecial(url.protocol)))
      ) {
        instructions[3] = [/(.*)/, 'pathname'];
      }

      for (; i < instructions.length; i++) {
        instruction = instructions[i];

        if (typeof instruction === 'function') {
          address = instruction(address, url);
          continue;
        }

        parse = instruction[0];
        key = instruction[1];

        if (parse !== parse) {
          url[key] = address;
        } else if ('string' === typeof parse) {
          index = parse === '@'
            ? address.lastIndexOf(parse)
            : address.indexOf(parse);

          if (~index) {
            if ('number' === typeof instruction[2]) {
              url[key] = address.slice(0, index);
              address = address.slice(index + instruction[2]);
            } else {
              url[key] = address.slice(index);
              address = address.slice(0, index);
            }
          }
        } else if ((index = parse.exec(address))) {
          url[key] = index[1];
          address = address.slice(0, index.index);
        }

        url[key] = url[key] || (
          relative && instruction[3] ? location[key] || '' : ''
        );

        //
        // Hostname, host and protocol should be lowercased so they can be used to
        // create a proper `origin`.
        //
        if (instruction[4]) url[key] = url[key].toLowerCase();
      }

      //
      // Also parse the supplied query string in to an object. If we're supplied
      // with a custom parser as function use that instead of the default build-in
      // parser.
      //
      if (parser) url.query = parser(url.query);

      //
      // If the URL is relative, resolve the pathname against the base URL.
      //
      if (
          relative
        && location.slashes
        && url.pathname.charAt(0) !== '/'
        && (url.pathname !== '' || location.pathname !== '')
      ) {
        url.pathname = resolve(url.pathname, location.pathname);
      }

      //
      // Default to a / for pathname if none exists. This normalizes the URL
      // to always have a /
      //
      if (url.pathname.charAt(0) !== '/' && isSpecial(url.protocol)) {
        url.pathname = '/' + url.pathname;
      }

      //
      // We should not add port numbers if they are already the default port number
      // for a given protocol. As the host also contains the port number we're going
      // override it with the hostname which contains no port number.
      //
      if (!required(url.port, url.protocol)) {
        url.host = url.hostname;
        url.port = '';
      }

      //
      // Parse down the `auth` for the username and password.
      //
      url.username = url.password = '';

      if (url.auth) {
        index = url.auth.indexOf(':');

        if (~index) {
          url.username = url.auth.slice(0, index);
          url.username = encodeURIComponent(decodeURIComponent(url.username));

          url.password = url.auth.slice(index + 1);
          url.password = encodeURIComponent(decodeURIComponent(url.password));
        } else {
          url.username = encodeURIComponent(decodeURIComponent(url.auth));
        }

        url.auth = url.password ? url.username +':'+ url.password : url.username;
      }

      url.origin = url.protocol !== 'file:' && isSpecial(url.protocol) && url.host
        ? url.protocol +'//'+ url.host
        : 'null';

      //
      // The href is just the compiled result.
      //
      url.href = url.toString();
    }

    /**
     * This is convenience method for changing properties in the URL instance to
     * insure that they all propagate correctly.
     *
     * @param {String} part          Property we need to adjust.
     * @param {Mixed} value          The newly assigned value.
     * @param {Boolean|Function} fn  When setting the query, it will be the function
     *                               used to parse the query.
     *                               When setting the protocol, double slash will be
     *                               removed from the final url if it is true.
     * @returns {URL} URL instance for chaining.
     * @public
     */
    function set(part, value, fn) {
      var url = this;

      switch (part) {
        case 'query':
          if ('string' === typeof value && value.length) {
            value = (fn || qs.parse)(value);
          }

          url[part] = value;
          break;

        case 'port':
          url[part] = value;

          if (!required(value, url.protocol)) {
            url.host = url.hostname;
            url[part] = '';
          } else if (value) {
            url.host = url.hostname +':'+ value;
          }

          break;

        case 'hostname':
          url[part] = value;

          if (url.port) value += ':'+ url.port;
          url.host = value;
          break;

        case 'host':
          url[part] = value;

          if (port.test(value)) {
            value = value.split(':');
            url.port = value.pop();
            url.hostname = value.join(':');
          } else {
            url.hostname = value;
            url.port = '';
          }

          break;

        case 'protocol':
          url.protocol = value.toLowerCase();
          url.slashes = !fn;
          break;

        case 'pathname':
        case 'hash':
          if (value) {
            var char = part === 'pathname' ? '/' : '#';
            url[part] = value.charAt(0) !== char ? char + value : value;
          } else {
            url[part] = value;
          }
          break;

        case 'username':
        case 'password':
          url[part] = encodeURIComponent(value);
          break;

        case 'auth':
          var index = value.indexOf(':');

          if (~index) {
            url.username = value.slice(0, index);
            url.username = encodeURIComponent(decodeURIComponent(url.username));

            url.password = value.slice(index + 1);
            url.password = encodeURIComponent(decodeURIComponent(url.password));
          } else {
            url.username = encodeURIComponent(decodeURIComponent(value));
          }
      }

      for (var i = 0; i < rules.length; i++) {
        var ins = rules[i];

        if (ins[4]) url[ins[1]] = url[ins[1]].toLowerCase();
      }

      url.auth = url.password ? url.username +':'+ url.password : url.username;

      url.origin = url.protocol !== 'file:' && isSpecial(url.protocol) && url.host
        ? url.protocol +'//'+ url.host
        : 'null';

      url.href = url.toString();

      return url;
    }

    /**
     * Transform the properties back in to a valid and full URL string.
     *
     * @param {Function} stringify Optional query stringify function.
     * @returns {String} Compiled version of the URL.
     * @public
     */
    function toString(stringify) {
      if (!stringify || 'function' !== typeof stringify) stringify = qs.stringify;

      var query
        , url = this
        , host = url.host
        , protocol = url.protocol;

      if (protocol && protocol.charAt(protocol.length - 1) !== ':') protocol += ':';

      var result =
        protocol +
        ((url.protocol && url.slashes) || isSpecial(url.protocol) ? '//' : '');

      if (url.username) {
        result += url.username;
        if (url.password) result += ':'+ url.password;
        result += '@';
      } else if (url.password) {
        result += ':'+ url.password;
        result += '@';
      } else if (
        url.protocol !== 'file:' &&
        isSpecial(url.protocol) &&
        !host &&
        url.pathname !== '/'
      ) {
        //
        // Add back the empty userinfo, otherwise the original invalid URL
        // might be transformed into a valid one with `url.pathname` as host.
        //
        result += '@';
      }

      //
      // Trailing colon is removed from `url.host` when it is parsed. If it still
      // ends with a colon, then add back the trailing colon that was removed. This
      // prevents an invalid URL from being transformed into a valid one.
      //
      if (host[host.length - 1] === ':' || (port.test(url.hostname) && !url.port)) {
        host += ':';
      }

      result += host + url.pathname;

      query = 'object' === typeof url.query ? stringify(url.query) : url.query;
      if (query) result += '?' !== query.charAt(0) ? '?'+ query : query;

      if (url.hash) result += url.hash;

      return result;
    }

    Url.prototype = { set: set, toString: toString };

    //
    // Expose the URL parser and some additional properties that might be useful for
    // others or testing.
    //
    Url.extractProtocol = extractProtocol;
    Url.location = lolcation;
    Url.trimLeft = trimLeft;
    Url.qs = qs;

    var urlParse = Url;

    (function (module, exports) {

    	Object.defineProperty(exports, "__esModule", {
    	  value: true
    	});
    	exports.default = void 0;

    	var _urlParse = _interopRequireDefault(urlParse);

    	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

    	function _extends() { _extends = Object.assign ? Object.assign.bind() : function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }

    	var isReactNative = typeof navigator === 'undefined' ? false : navigator.product === 'ReactNative';
    	var has = Object.prototype.hasOwnProperty;
    	var defaultOptions = {
    	  timeout: isReactNative ? 60000 : 120000
    	};

    	var _default = function _default(opts) {
    	  var options = typeof opts === 'string' ? _extends({
    	    url: opts
    	  }, defaultOptions) : _extends({}, defaultOptions, opts); // Parse URL into parts

    	  var url = (0, _urlParse.default)(options.url, {}, // Don't use current browser location
    	  true // Parse query strings
    	  ); // Normalize timeouts

    	  options.timeout = normalizeTimeout(options.timeout); // Shallow-merge (override) existing query params

    	  if (options.query) {
    	    url.query = _extends({}, url.query, removeUndefined(options.query));
    	  } // Implicit POST if we have not specified a method but have a body


    	  options.method = options.body && !options.method ? 'POST' : (options.method || 'GET').toUpperCase(); // Stringify URL

    	  options.url = url.toString(stringifyQueryString);
    	  return options;
    	};

    	exports.default = _default;

    	function stringifyQueryString(obj) {
    	  var pairs = [];

    	  for (var key in obj) {
    	    if (has.call(obj, key)) {
    	      push(key, obj[key]);
    	    }
    	  }

    	  return pairs.length ? pairs.join('&') : '';

    	  function push(key, val) {
    	    if (Array.isArray(val)) {
    	      val.forEach(function (item) {
    	        return push(key, item);
    	      });
    	    } else {
    	      pairs.push([key, val].map(encodeURIComponent).join('='));
    	    }
    	  }
    	}

    	function normalizeTimeout(time) {
    	  if (time === false || time === 0) {
    	    return false;
    	  }

    	  if (time.connect || time.socket) {
    	    return time;
    	  }

    	  var delay = Number(time);

    	  if (isNaN(delay)) {
    	    return normalizeTimeout(defaultOptions.timeout);
    	  }

    	  return {
    	    connect: delay,
    	    socket: delay
    	  };
    	}

    	function removeUndefined(obj) {
    	  var target = {};

    	  for (var key in obj) {
    	    if (obj[key] !== undefined) {
    	      target[key] = obj[key];
    	    }
    	  }

    	  return target;
    	}

    	module.exports = exports.default;
    	
    } (defaultOptionsProcessor, defaultOptionsProcessorExports));

    var defaultOptionsValidatorExports = {};
    var defaultOptionsValidator = {
      get exports(){ return defaultOptionsValidatorExports; },
      set exports(v){ defaultOptionsValidatorExports = v; },
    };

    (function (module, exports) {

    	Object.defineProperty(exports, "__esModule", {
    	  value: true
    	});
    	exports.default = void 0;
    	var validUrl = /^https?:\/\//i;

    	var _default = function _default(options) {
    	  if (!validUrl.test(options.url)) {
    	    throw new Error("\"".concat(options.url, "\" is not a valid URL"));
    	  }
    	};

    	exports.default = _default;
    	module.exports = exports.default;
    	
    } (defaultOptionsValidator, defaultOptionsValidatorExports));

    var requestExports = {};
    var request$1 = {
      get exports(){ return requestExports; },
      set exports(v){ requestExports = v; },
    };

    var browserRequestExports = {};
    var browserRequest = {
      get exports(){ return browserRequestExports; },
      set exports(v){ browserRequestExports = v; },
    };

    /**
     * This file is only used for the browser version of `same-origin`.
     * Used to bring down the size of the browser bundle.
     */

    var regex = /^(?:(?:(?:([^:\/#\?]+:)?(?:(?:\/\/)((?:((?:[^:@\/#\?]+)(?:\:(?:[^:@\/#\?]+))?)@)?(([^:\/#\?\]\[]+|\[[^\/\]@#?]+\])(?:\:([0-9]+))?))?)?)?((?:\/?(?:[^\/\?#]+\/+)*)(?:[^\?#]*)))?(\?[^#]+)?)(#.*)?/;

    var urlParser = {
        regex: regex,
        parse: function(url) {
            var match = regex.exec(url);
            if (!match) {
                return {};
            }

            return {
                protocol: (match[1] || '').toLowerCase() || undefined,
                hostname: (match[5] || '').toLowerCase() || undefined,
                port: match[6] || undefined
            };
        }
    };

    var url = urlParser;

    var sameOrigin = function(uri1, uri2, ieMode) {
        if (uri1 === uri2) {
            return true;
        }

        var url1 = url.parse(uri1, false, true);
        var url2 = url.parse(uri2, false, true);

        var url1Port = url1.port|0 || (url1.protocol === 'https' ? 443 : 80);
        var url2Port = url2.port|0 || (url2.protocol === 'https' ? 443 : 80);

        var match = {
            proto: url1.protocol === url2.protocol,
            hostname: url1.hostname === url2.hostname,
            port: url1Port === url2Port
        };

        return ((match.proto && match.hostname) && (match.port || ieMode));
    };

    var trim = function(string) {
      return string.replace(/^\s+|\s+$/g, '');
    }
      , isArray$1 = function(arg) {
          return Object.prototype.toString.call(arg) === '[object Array]';
        };

    var parseHeaders = function (headers) {
      if (!headers)
        return {}

      var result = {};

      var headersArr = trim(headers).split('\n');

      for (var i = 0; i < headersArr.length; i++) {
        var row = headersArr[i];
        var index = row.indexOf(':')
        , key = trim(row.slice(0, index)).toLowerCase()
        , value = trim(row.slice(index + 1));

        if (typeof(result[key]) === 'undefined') {
          result[key] = value;
        } else if (isArray$1(result[key])) {
          result[key].push(value);
        } else {
          result[key] = [ result[key], value ];
        }
      }

      return result
    };

    var fetchXhrExports = {};
    var fetchXhr = {
      get exports(){ return fetchXhrExports; },
      set exports(v){ fetchXhrExports = v; },
    };

    (function (module, exports) {

    	Object.defineProperty(exports, "__esModule", {
    	  value: true
    	});
    	exports.default = void 0;

    	/**
    	 * Mimicks the XMLHttpRequest API with only the parts needed for get-it's XHR adapter
    	 */
    	function FetchXhr() {
    	  this.readyState = 0; // Unsent
    	}

    	FetchXhr.prototype.open = function (method, url) {
    	  this._method = method;
    	  this._url = url;
    	  this._resHeaders = '';
    	  this.readyState = 1; // Open

    	  this.onreadystatechange();
    	};

    	FetchXhr.prototype.abort = function () {
    	  if (this._controller) {
    	    this._controller.abort();
    	  }
    	};

    	FetchXhr.prototype.getAllResponseHeaders = function () {
    	  return this._resHeaders;
    	};

    	FetchXhr.prototype.setRequestHeader = function (key, value) {
    	  this._headers = this._headers || {};
    	  this._headers[key] = value;
    	};

    	FetchXhr.prototype.send = function (body) {
    	  var _this = this;

    	  // eslint-disable-next-line no-multi-assign
    	  var ctrl = this._controller = typeof AbortController === 'function' && new AbortController();
    	  var textBody = this.responseType !== 'arraybuffer';
    	  var options = {
    	    method: this._method,
    	    headers: this._headers,
    	    signal: ctrl && ctrl.signal || undefined,
    	    body: body
    	  }; // Some environments (like CloudFlare workers) don't support credentials in
    	  // RequestInitDict, and there doesn't seem to be any easy way to check for it,
    	  // so for now let's just make do with a window check :/

    	  if (typeof document !== 'undefined') {
    	    options.credentials = this.withCredentials ? 'include' : 'omit';
    	  }

    	  fetch(this._url, options).then(function (res) {
    	    res.headers.forEach(function (value, key) {
    	      _this._resHeaders += "".concat(key, ": ").concat(value, "\r\n");
    	    });
    	    _this.status = res.status;
    	    _this.statusText = res.statusText;
    	    _this.readyState = 3; // Loading

    	    return textBody ? res.text() : res.arrayBuffer();
    	  }).then(function (resBody) {
    	    if (textBody) {
    	      _this.responseText = resBody;
    	    } else {
    	      _this.response = resBody;
    	    }

    	    _this.readyState = 4; // Done

    	    _this.onreadystatechange();
    	  }).catch(function (err) {
    	    if (err.name === 'AbortError') {
    	      _this.onabort();

    	      return;
    	    }

    	    _this.onerror(err);
    	  });
    	};

    	var _default = FetchXhr;
    	exports.default = _default;
    	module.exports = exports.default;
    	
    } (fetchXhr, fetchXhrExports));

    (function (module, exports) {

    	Object.defineProperty(exports, "__esModule", {
    	  value: true
    	});
    	exports.default = void 0;

    	var _sameOrigin = _interopRequireDefault(sameOrigin);

    	var _parseHeaders = _interopRequireDefault(parseHeaders);

    	var _fetchXhr = _interopRequireDefault(fetchXhrExports);

    	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

    	/* eslint max-depth: ["error", 4] */
    	var noop = function noop() {
    	  /* intentional noop */
    	};

    	var win = typeof document === 'undefined' || typeof window === 'undefined' ? undefined : window;
    	var adapter = win ? 'xhr' : 'fetch';
    	var XmlHttpRequest = typeof XMLHttpRequest === 'function' ? XMLHttpRequest : noop;
    	var hasXhr2 = ('withCredentials' in new XmlHttpRequest()); // eslint-disable-next-line no-undef

    	var XDR = typeof XDomainRequest === 'undefined' ? undefined : XDomainRequest;
    	var CrossDomainRequest = hasXhr2 ? XmlHttpRequest : XDR; // Fallback to fetch-based XHR polyfill for non-browser environments like Workers

    	if (!win) {
    	  XmlHttpRequest = _fetchXhr.default;
    	  CrossDomainRequest = _fetchXhr.default;
    	}

    	var _default = function _default(context, callback) {
    	  var opts = context.options;
    	  var options = context.applyMiddleware('finalizeOptions', opts);
    	  var timers = {}; // Deep-checking window.location because of react native, where `location` doesn't exist

    	  var cors = win && win.location && !(0, _sameOrigin.default)(win.location.href, options.url); // Allow middleware to inject a response, for instance in the case of caching or mocking

    	  var injectedResponse = context.applyMiddleware('interceptRequest', undefined, {
    	    adapter: adapter,
    	    context: context
    	  }); // If middleware injected a response, treat it as we normally would and return it
    	  // Do note that the injected response has to be reduced to a cross-environment friendly response

    	  if (injectedResponse) {
    	    var cbTimer = setTimeout(callback, 0, null, injectedResponse);

    	    var cancel = function cancel() {
    	      return clearTimeout(cbTimer);
    	    };

    	    return {
    	      abort: cancel
    	    };
    	  } // We'll want to null out the request on success/failure


    	  var xhr = cors ? new CrossDomainRequest() : new XmlHttpRequest();
    	  var isXdr = win && win.XDomainRequest && xhr instanceof win.XDomainRequest;
    	  var headers = options.headers;
    	  var delays = options.timeout; // Request state

    	  var aborted = false;
    	  var loaded = false;
    	  var timedOut = false; // Apply event handlers

    	  xhr.onerror = onError;
    	  xhr.ontimeout = onError;

    	  xhr.onabort = function () {
    	    stopTimers(true);
    	    aborted = true;
    	  }; // IE9 must have onprogress be set to a unique function


    	  xhr.onprogress = function () {
    	    /* intentional noop */
    	  };

    	  var loadEvent = isXdr ? 'onload' : 'onreadystatechange';

    	  xhr[loadEvent] = function () {
    	    // Prevent request from timing out
    	    resetTimers();

    	    if (aborted || xhr.readyState !== 4 && !isXdr) {
    	      return;
    	    } // Will be handled by onError


    	    if (xhr.status === 0) {
    	      return;
    	    }

    	    onLoad();
    	  }; // @todo two last options to open() is username/password


    	  xhr.open(options.method, options.url, true // Always async
    	  ); // Some options need to be applied after open

    	  xhr.withCredentials = !!options.withCredentials; // Set headers

    	  if (headers && xhr.setRequestHeader) {
    	    for (var key in headers) {
    	      if (headers.hasOwnProperty(key)) {
    	        xhr.setRequestHeader(key, headers[key]);
    	      }
    	    }
    	  } else if (headers && isXdr) {
    	    throw new Error('Headers cannot be set on an XDomainRequest object');
    	  }

    	  if (options.rawBody) {
    	    xhr.responseType = 'arraybuffer';
    	  } // Let middleware know we're about to do a request


    	  context.applyMiddleware('onRequest', {
    	    options: options,
    	    adapter: adapter,
    	    request: xhr,
    	    context: context
    	  });
    	  xhr.send(options.body || null); // Figure out which timeouts to use (if any)

    	  if (delays) {
    	    timers.connect = setTimeout(function () {
    	      return timeoutRequest('ETIMEDOUT');
    	    }, delays.connect);
    	  }

    	  return {
    	    abort: abort
    	  };

    	  function abort() {
    	    aborted = true;

    	    if (xhr) {
    	      xhr.abort();
    	    }
    	  }

    	  function timeoutRequest(code) {
    	    timedOut = true;
    	    xhr.abort();
    	    var error = new Error(code === 'ESOCKETTIMEDOUT' ? "Socket timed out on request to ".concat(options.url) : "Connection timed out on request to ".concat(options.url));
    	    error.code = code;
    	    context.channels.error.publish(error);
    	  }

    	  function resetTimers() {
    	    if (!delays) {
    	      return;
    	    }

    	    stopTimers();
    	    timers.socket = setTimeout(function () {
    	      return timeoutRequest('ESOCKETTIMEDOUT');
    	    }, delays.socket);
    	  }

    	  function stopTimers(force) {
    	    // Only clear the connect timeout if we've got a connection
    	    if (force || aborted || xhr.readyState >= 2 && timers.connect) {
    	      clearTimeout(timers.connect);
    	    }

    	    if (timers.socket) {
    	      clearTimeout(timers.socket);
    	    }
    	  }

    	  function onError(error) {
    	    if (loaded) {
    	      return;
    	    } // Clean up


    	    stopTimers(true);
    	    loaded = true;
    	    xhr = null; // Annoyingly, details are extremely scarce and hidden from us.
    	    // We only really know that it is a network error

    	    var err = error || new Error("Network error while attempting to reach ".concat(options.url));
    	    err.isNetworkError = true;
    	    err.request = options;
    	    callback(err);
    	  }

    	  function reduceResponse() {
    	    var statusCode = xhr.status;
    	    var statusMessage = xhr.statusText;

    	    if (isXdr && statusCode === undefined) {
    	      // IE8 CORS GET successful response doesn't have a status field, but body is fine
    	      statusCode = 200;
    	    } else if (statusCode > 12000 && statusCode < 12156) {
    	      // Yet another IE quirk where it emits weird status codes on network errors
    	      // https://support.microsoft.com/en-us/kb/193625
    	      return onError();
    	    } else {
    	      // Another IE bug where HTTP 204 somehow ends up as 1223
    	      statusCode = xhr.status === 1223 ? 204 : xhr.status;
    	      statusMessage = xhr.status === 1223 ? 'No Content' : statusMessage;
    	    }

    	    return {
    	      body: xhr.response || xhr.responseText,
    	      url: options.url,
    	      method: options.method,
    	      headers: isXdr ? {} : (0, _parseHeaders.default)(xhr.getAllResponseHeaders()),
    	      statusCode: statusCode,
    	      statusMessage: statusMessage
    	    };
    	  }

    	  function onLoad() {
    	    if (aborted || loaded || timedOut) {
    	      return;
    	    }

    	    if (xhr.status === 0) {
    	      onError(new Error('Unknown XHR error'));
    	      return;
    	    } // Prevent being called twice


    	    stopTimers();
    	    loaded = true;
    	    callback(null, reduceResponse());
    	  }
    	};

    	exports.default = _default;
    	module.exports = exports.default;
    	
    } (browserRequest, browserRequestExports));

    (function (module, exports) {

    	Object.defineProperty(exports, "__esModule", {
    	  value: true
    	});
    	exports.default = void 0;

    	var _nodeRequest = _interopRequireDefault(browserRequestExports);

    	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

    	var _default = _nodeRequest.default;
    	exports.default = _default;
    	module.exports = exports.default;
    	
    } (request$1, requestExports));

    (function (module, exports) {

    	Object.defineProperty(exports, "__esModule", {
    	  value: true
    	});
    	exports.default = createRequester;

    	var _nanoPubsub = _interopRequireDefault(require$$0);

    	var _middlewareReducer = _interopRequireDefault(middlewareReducerExports);

    	var _defaultOptionsProcessor = _interopRequireDefault(defaultOptionsProcessorExports);

    	var _defaultOptionsValidator = _interopRequireDefault(defaultOptionsValidatorExports);

    	var _request = _interopRequireDefault(requestExports);

    	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

    	// node-request in node, browser-request in browsers
    	// Workaround default export weirdness
    	var pubsub = 'default' in _nanoPubsub.default ? _nanoPubsub.default.default : _nanoPubsub.default;
    	var channelNames = ['request', 'response', 'progress', 'error', 'abort'];
    	var middlehooks = ['processOptions', 'validateOptions', 'interceptRequest', 'finalizeOptions', 'onRequest', 'onResponse', 'onError', 'onReturn', 'onHeaders'];

    	function createRequester() {
    	  var initMiddleware = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
    	  var httpRequest = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : _request.default;
    	  var loadedMiddleware = [];
    	  var middleware = middlehooks.reduce(function (ware, name) {
    	    ware[name] = ware[name] || [];
    	    return ware;
    	  }, {
    	    processOptions: [_defaultOptionsProcessor.default],
    	    validateOptions: [_defaultOptionsValidator.default]
    	  });

    	  function request(opts) {
    	    var channels = channelNames.reduce(function (target, name) {
    	      target[name] = pubsub();
    	      return target;
    	    }, {}); // Prepare a middleware reducer that can be reused throughout the lifecycle

    	    var applyMiddleware = (0, _middlewareReducer.default)(middleware); // Parse the passed options

    	    var options = applyMiddleware('processOptions', opts); // Validate the options

    	    applyMiddleware('validateOptions', options); // Build a context object we can pass to child handlers

    	    var context = {
    	      options: options,
    	      channels: channels,
    	      applyMiddleware: applyMiddleware
    	    }; // We need to hold a reference to the current, ongoing request,
    	    // in order to allow cancellation. In the case of the retry middleware,
    	    // a new request might be triggered

    	    var ongoingRequest = null;
    	    var unsubscribe = channels.request.subscribe(function (ctx) {
    	      // Let request adapters (node/browser) perform the actual request
    	      ongoingRequest = httpRequest(ctx, function (err, res) {
    	        return onResponse(err, res, ctx);
    	      });
    	    }); // If we abort the request, prevent further requests from happening,
    	    // and be sure to cancel any ongoing request (obviously)

    	    channels.abort.subscribe(function () {
    	      unsubscribe();

    	      if (ongoingRequest) {
    	        ongoingRequest.abort();
    	      }
    	    }); // See if any middleware wants to modify the return value - for instance
    	    // the promise or observable middlewares

    	    var returnValue = applyMiddleware('onReturn', channels, context); // If return value has been modified by a middleware, we expect the middleware
    	    // to publish on the 'request' channel. If it hasn't been modified, we want to
    	    // trigger it right away

    	    if (returnValue === channels) {
    	      channels.request.publish(context);
    	    }

    	    return returnValue;

    	    function onResponse(reqErr, res, ctx) {
    	      var error = reqErr;
    	      var response = res; // We're processing non-errors first, in case a middleware converts the
    	      // response into an error (for instance, status >= 400 == HttpError)

    	      if (!error) {
    	        try {
    	          response = applyMiddleware('onResponse', res, ctx);
    	        } catch (err) {
    	          response = null;
    	          error = err;
    	        }
    	      } // Apply error middleware - if middleware return the same (or a different) error,
    	      // publish as an error event. If we *don't* return an error, assume it has been handled


    	      error = error && applyMiddleware('onError', error, ctx); // Figure out if we should publish on error/response channels

    	      if (error) {
    	        channels.error.publish(error);
    	      } else if (response) {
    	        channels.response.publish(response);
    	      }
    	    }
    	  }

    	  request.use = function use(newMiddleware) {
    	    if (!newMiddleware) {
    	      throw new Error('Tried to add middleware that resolved to falsey value');
    	    }

    	    if (typeof newMiddleware === 'function') {
    	      throw new Error('Tried to add middleware that was a function. It probably expects you to pass options to it.');
    	    }

    	    if (newMiddleware.onReturn && middleware.onReturn.length > 0) {
    	      throw new Error('Tried to add new middleware with `onReturn` handler, but another handler has already been registered for this event');
    	    }

    	    middlehooks.forEach(function (key) {
    	      if (newMiddleware[key]) {
    	        middleware[key].push(newMiddleware[key]);
    	      }
    	    });
    	    loadedMiddleware.push(newMiddleware);
    	    return request;
    	  };

    	  request.clone = function clone() {
    	    return createRequester(loadedMiddleware);
    	  };

    	  initMiddleware.forEach(request.use);
    	  return request;
    	}

    	module.exports = exports.default;
    	
    } (lib$1, libExports));

    var getIt = /*@__PURE__*/getDefaultExportFromCjs(libExports);

    // node_modules/is-plain-object/dist/is-plain-object.mjs
    function isObject(o) {
      return Object.prototype.toString.call(o) === "[object Object]";
    }
    function isPlainObject(o) {
      var ctor, prot;
      if (isObject(o) === false)
        return false;
      ctor = o.constructor;
      if (ctor === void 0)
        return true;
      prot = ctor.prototype;
      if (isObject(prot) === false)
        return false;
      if (prot.hasOwnProperty("isPrototypeOf") === false) {
        return false;
      }
      return true;
    }
    /*!
     * is-plain-object <https://github.com/jonschlinkert/is-plain-object>
     *
     * Copyright (c) 2014-2017, Jon Schlinkert.
     * Released under the MIT License.
     */

    var __create$1 = Object.create;
    var __defProp$1 = Object.defineProperty;
    var __getOwnPropDesc$1 = Object.getOwnPropertyDescriptor;
    var __getOwnPropNames$1 = Object.getOwnPropertyNames;
    var __getProtoOf$1 = Object.getPrototypeOf;
    var __hasOwnProp$1 = Object.prototype.hasOwnProperty;
    var __esm = (fn, res) => function __init() {
      return fn && (res = (0, fn[__getOwnPropNames$1(fn)[0]])(fn = 0)), res;
    };
    var __commonJS$1 = (cb, mod) => function __require() {
      return mod || (0, cb[__getOwnPropNames$1(cb)[0]])((mod = { exports: {} }).exports, mod), mod.exports;
    };
    var __export = (target, all) => {
      for (var name in all)
        __defProp$1(target, name, { get: all[name], enumerable: true });
    };
    var __copyProps$1 = (to, from, except, desc) => {
      if (from && typeof from === "object" || typeof from === "function") {
        for (let key of __getOwnPropNames$1(from))
          if (!__hasOwnProp$1.call(to, key) && key !== except)
            __defProp$1(to, key, { get: () => from[key], enumerable: !(desc = __getOwnPropDesc$1(from, key)) || desc.enumerable });
      }
      return to;
    };
    var __toESM$1 = (mod, isNodeMode, target) => (target = mod != null ? __create$1(__getProtoOf$1(mod)) : {}, __copyProps$1(
      isNodeMode || !mod || !mod.__esModule ? __defProp$1(target, "default", { value: mod, enumerable: true }) : target,
      mod
    ));
    var __toCommonJS = (mod) => __copyProps$1(__defProp$1({}, "__esModule", { value: true }), mod);

    // node_modules/form-urlencoded/dist/form-urlencoded.js
    var require_form_urlencoded = __commonJS$1({
      "node_modules/form-urlencoded/dist/form-urlencoded.js"(exports, module) {
        var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function(obj) {
          return typeof obj;
        } : function(obj) {
          return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
        };
        module.exports = function(data) {
          var opts = arguments.length > 1 && arguments[1] !== void 0 ? arguments[1] : {};
          var sorted = Boolean(opts.sorted), skipIndex = Boolean(opts.skipIndex), ignorenull = Boolean(opts.ignorenull), encode2 = function encode3(value) {
            return String(value).replace(/(?:[\0-\x1F"-&\+-\}\x7F-\uD7FF\uE000-\uFFFF]|[\uD800-\uDBFF][\uDC00-\uDFFF]|[\uD800-\uDBFF](?![\uDC00-\uDFFF])|(?:[^\uD800-\uDBFF]|^)[\uDC00-\uDFFF])/g, encodeURIComponent).replace(/ /g, "+").replace(/[!'()~\*]/g, function(ch) {
              return "%" + ch.charCodeAt().toString(16).slice(-2).toUpperCase();
            });
          }, keys = function keys2(obj) {
            var keyarr = arguments.length > 1 && arguments[1] !== void 0 ? arguments[1] : Object.keys(obj);
            return sorted ? keyarr.sort() : keyarr;
          }, filterjoin = function filterjoin2(arr) {
            return arr.filter(function(e) {
              return e;
            }).join("&");
          }, objnest = function objnest2(name, obj) {
            return filterjoin(keys(obj).map(function(key) {
              return nest(name + "[" + key + "]", obj[key]);
            }));
          }, arrnest = function arrnest2(name, arr) {
            return arr.length ? filterjoin(arr.map(function(elem, index) {
              return skipIndex ? nest(name + "[]", elem) : nest(name + "[" + index + "]", elem);
            })) : encode2(name + "[]");
          }, nest = function nest2(name, value) {
            var type = arguments.length > 2 && arguments[2] !== void 0 ? arguments[2] : typeof value === "undefined" ? "undefined" : _typeof(value);
            var f = arguments.length > 3 && arguments[3] !== void 0 ? arguments[3] : null;
            if (value === f)
              f = ignorenull ? f : encode2(name) + "=" + f;
            else if (/string|number|boolean/.test(type))
              f = encode2(name) + "=" + encode2(value);
            else if (Array.isArray(value))
              f = arrnest(name, value);
            else if (type === "object")
              f = objnest(name, value);
            return f;
          };
          return data && filterjoin(keys(data).map(function(key) {
            return nest(key, data[key]);
          }));
        };
      }
    });

    // src/middleware/urlEncoded.js
    var import_form_urlencoded = __toESM$1(require_form_urlencoded());
    import_form_urlencoded.default.default || import_form_urlencoded.default;

    // src/middleware/progress/browser-progress.js
    var browser_progress_default = () => ({
      onRequest: (evt) => {
        if (evt.adapter !== "xhr") {
          return;
        }
        const xhr = evt.request;
        const context = evt.context;
        if ("upload" in xhr && "onprogress" in xhr.upload) {
          xhr.upload.onprogress = handleProgress("upload");
        }
        if ("onprogress" in xhr) {
          xhr.onprogress = handleProgress("download");
        }
        function handleProgress(stage) {
          return (event) => {
            const percent = event.lengthComputable ? event.loaded / event.total * 100 : -1;
            context.channels.progress.publish({
              stage,
              percent,
              total: event.total,
              loaded: event.loaded,
              lengthComputable: event.lengthComputable
            });
          };
        }
      }
    });

    // src/middleware/jsonRequest.js
    var serializeTypes = ["boolean", "string", "number"];
    var isBuffer = (obj) => !!obj.constructor && typeof obj.constructor.isBuffer === "function" && obj.constructor.isBuffer(obj);
    var jsonRequest_default = () => ({
      processOptions: (options) => {
        const body = options.body;
        if (!body) {
          return options;
        }
        const isStream = typeof body.pipe === "function";
        const shouldSerialize = !isStream && !isBuffer(body) && (serializeTypes.indexOf(typeof body) !== -1 || Array.isArray(body) || isPlainObject(body));
        if (!shouldSerialize) {
          return options;
        }
        return Object.assign({}, options, {
          body: JSON.stringify(options.body),
          headers: Object.assign({}, options.headers, {
            "Content-Type": "application/json"
          })
        });
      }
    });

    // src/middleware/jsonResponse.js
    var jsonResponse_default = (opts) => ({
      onResponse: (response) => {
        const contentType = response.headers["content-type"] || "";
        const shouldDecode = opts && opts.force || contentType.indexOf("application/json") !== -1;
        if (!response.body || !contentType || !shouldDecode) {
          return response;
        }
        return Object.assign({}, response, { body: tryParse(response.body) });
      },
      processOptions: (options) => Object.assign({}, options, {
        headers: Object.assign({ Accept: "application/json" }, options.headers)
      })
    });
    function tryParse(body) {
      try {
        return JSON.parse(body);
      } catch (err) {
        err.message = `Failed to parsed response body as JSON: ${err.message}`;
        throw err;
      }
    }

    // src/util/global.js
    var actualGlobal;
    if (typeof globalThis !== "undefined") {
      actualGlobal = globalThis;
    } else if (typeof window !== "undefined") {
      actualGlobal = window;
    } else if (typeof global !== "undefined") {
      actualGlobal = global;
    } else if (typeof self !== "undefined") {
      actualGlobal = self;
    } else {
      actualGlobal = {};
    }
    var global_default = actualGlobal;

    // src/middleware/observable.js
    var observable_default = (opts = {}) => {
      const Observable = opts.implementation || global_default.Observable;
      if (!Observable) {
        throw new Error(
          "`Observable` is not available in global scope, and no implementation was passed"
        );
      }
      return {
        onReturn: (channels, context) => new Observable((observer) => {
          channels.error.subscribe((err) => observer.error(err));
          channels.progress.subscribe(
            (event) => observer.next(Object.assign({ type: "progress" }, event))
          );
          channels.response.subscribe((response) => {
            observer.next(Object.assign({ type: "response" }, response));
            observer.complete();
          });
          channels.request.publish(context);
          return () => channels.abort.publish();
        })
      };
    };

    // src/middleware/cancel/Cancel.js
    var Cancel_exports = {};
    __export(Cancel_exports, {
      default: () => Cancel_default
    });
    function Cancel(message) {
      this.message = message;
    }
    var Cancel_default;
    var init_Cancel = __esm({
      "src/middleware/cancel/Cancel.js"() {
        Cancel.prototype.toString = function toString() {
          return `Cancel${this.message ? `: ${this.message}` : ""}`;
        };
        Cancel.prototype.__CANCEL__ = true;
        Cancel_default = Cancel;
      }
    });

    // src/middleware/promise.js
    init_Cancel();

    // src/middleware/cancel/CancelToken.js
    var Cancel2 = (init_Cancel(), __toCommonJS(Cancel_exports));
    function CancelToken(executor) {
      if (typeof executor !== "function") {
        throw new TypeError("executor must be a function.");
      }
      let resolvePromise = null;
      this.promise = new Promise((resolve) => {
        resolvePromise = resolve;
      });
      executor((message) => {
        if (this.reason) {
          return;
        }
        this.reason = new Cancel2(message);
        resolvePromise(this.reason);
      });
    }
    CancelToken.source = function() {
      let cancel;
      const token = new CancelToken((can) => {
        cancel = can;
      });
      return {
        token,
        cancel
      };
    };

    // node_modules/ms/index.js
    var require_ms = __commonJS$1({
      "node_modules/ms/index.js"(exports, module) {
        var s = 1e3;
        var m = s * 60;
        var h = m * 60;
        var d = h * 24;
        var w = d * 7;
        var y = d * 365.25;
        module.exports = function(val, options) {
          options = options || {};
          var type = typeof val;
          if (type === "string" && val.length > 0) {
            return parse(val);
          } else if (type === "number" && isFinite(val)) {
            return options.long ? fmtLong(val) : fmtShort(val);
          }
          throw new Error(
            "val is not a non-empty string or a valid number. val=" + JSON.stringify(val)
          );
        };
        function parse(str) {
          str = String(str);
          if (str.length > 100) {
            return;
          }
          var match = /^(-?(?:\d+)?\.?\d+) *(milliseconds?|msecs?|ms|seconds?|secs?|s|minutes?|mins?|m|hours?|hrs?|h|days?|d|weeks?|w|years?|yrs?|y)?$/i.exec(
            str
          );
          if (!match) {
            return;
          }
          var n = parseFloat(match[1]);
          var type = (match[2] || "ms").toLowerCase();
          switch (type) {
            case "years":
            case "year":
            case "yrs":
            case "yr":
            case "y":
              return n * y;
            case "weeks":
            case "week":
            case "w":
              return n * w;
            case "days":
            case "day":
            case "d":
              return n * d;
            case "hours":
            case "hour":
            case "hrs":
            case "hr":
            case "h":
              return n * h;
            case "minutes":
            case "minute":
            case "mins":
            case "min":
            case "m":
              return n * m;
            case "seconds":
            case "second":
            case "secs":
            case "sec":
            case "s":
              return n * s;
            case "milliseconds":
            case "millisecond":
            case "msecs":
            case "msec":
            case "ms":
              return n;
            default:
              return void 0;
          }
        }
        function fmtShort(ms) {
          var msAbs = Math.abs(ms);
          if (msAbs >= d) {
            return Math.round(ms / d) + "d";
          }
          if (msAbs >= h) {
            return Math.round(ms / h) + "h";
          }
          if (msAbs >= m) {
            return Math.round(ms / m) + "m";
          }
          if (msAbs >= s) {
            return Math.round(ms / s) + "s";
          }
          return ms + "ms";
        }
        function fmtLong(ms) {
          var msAbs = Math.abs(ms);
          if (msAbs >= d) {
            return plural(ms, msAbs, d, "day");
          }
          if (msAbs >= h) {
            return plural(ms, msAbs, h, "hour");
          }
          if (msAbs >= m) {
            return plural(ms, msAbs, m, "minute");
          }
          if (msAbs >= s) {
            return plural(ms, msAbs, s, "second");
          }
          return ms + " ms";
        }
        function plural(ms, msAbs, n, name) {
          var isPlural = msAbs >= n * 1.5;
          return Math.round(ms / n) + " " + name + (isPlural ? "s" : "");
        }
      }
    });

    // node_modules/debug/src/common.js
    var require_common = __commonJS$1({
      "node_modules/debug/src/common.js"(exports, module) {
        function setup(env) {
          createDebug.debug = createDebug;
          createDebug.default = createDebug;
          createDebug.coerce = coerce;
          createDebug.disable = disable;
          createDebug.enable = enable;
          createDebug.enabled = enabled;
          createDebug.humanize = require_ms();
          createDebug.destroy = destroy;
          Object.keys(env).forEach((key) => {
            createDebug[key] = env[key];
          });
          createDebug.names = [];
          createDebug.skips = [];
          createDebug.formatters = {};
          function selectColor(namespace) {
            let hash = 0;
            for (let i = 0; i < namespace.length; i++) {
              hash = (hash << 5) - hash + namespace.charCodeAt(i);
              hash |= 0;
            }
            return createDebug.colors[Math.abs(hash) % createDebug.colors.length];
          }
          createDebug.selectColor = selectColor;
          function createDebug(namespace) {
            let prevTime;
            let enableOverride = null;
            let namespacesCache;
            let enabledCache;
            function debug(...args) {
              if (!debug.enabled) {
                return;
              }
              const self = debug;
              const curr = Number(new Date());
              const ms = curr - (prevTime || curr);
              self.diff = ms;
              self.prev = prevTime;
              self.curr = curr;
              prevTime = curr;
              args[0] = createDebug.coerce(args[0]);
              if (typeof args[0] !== "string") {
                args.unshift("%O");
              }
              let index = 0;
              args[0] = args[0].replace(/%([a-zA-Z%])/g, (match, format) => {
                if (match === "%%") {
                  return "%";
                }
                index++;
                const formatter = createDebug.formatters[format];
                if (typeof formatter === "function") {
                  const val = args[index];
                  match = formatter.call(self, val);
                  args.splice(index, 1);
                  index--;
                }
                return match;
              });
              createDebug.formatArgs.call(self, args);
              const logFn = self.log || createDebug.log;
              logFn.apply(self, args);
            }
            debug.namespace = namespace;
            debug.useColors = createDebug.useColors();
            debug.color = createDebug.selectColor(namespace);
            debug.extend = extend;
            debug.destroy = createDebug.destroy;
            Object.defineProperty(debug, "enabled", {
              enumerable: true,
              configurable: false,
              get: () => {
                if (enableOverride !== null) {
                  return enableOverride;
                }
                if (namespacesCache !== createDebug.namespaces) {
                  namespacesCache = createDebug.namespaces;
                  enabledCache = createDebug.enabled(namespace);
                }
                return enabledCache;
              },
              set: (v) => {
                enableOverride = v;
              }
            });
            if (typeof createDebug.init === "function") {
              createDebug.init(debug);
            }
            return debug;
          }
          function extend(namespace, delimiter) {
            const newDebug = createDebug(this.namespace + (typeof delimiter === "undefined" ? ":" : delimiter) + namespace);
            newDebug.log = this.log;
            return newDebug;
          }
          function enable(namespaces) {
            createDebug.save(namespaces);
            createDebug.namespaces = namespaces;
            createDebug.names = [];
            createDebug.skips = [];
            let i;
            const split = (typeof namespaces === "string" ? namespaces : "").split(/[\s,]+/);
            const len = split.length;
            for (i = 0; i < len; i++) {
              if (!split[i]) {
                continue;
              }
              namespaces = split[i].replace(/\*/g, ".*?");
              if (namespaces[0] === "-") {
                createDebug.skips.push(new RegExp("^" + namespaces.slice(1) + "$"));
              } else {
                createDebug.names.push(new RegExp("^" + namespaces + "$"));
              }
            }
          }
          function disable() {
            const namespaces = [
              ...createDebug.names.map(toNamespace),
              ...createDebug.skips.map(toNamespace).map((namespace) => "-" + namespace)
            ].join(",");
            createDebug.enable("");
            return namespaces;
          }
          function enabled(name) {
            if (name[name.length - 1] === "*") {
              return true;
            }
            let i;
            let len;
            for (i = 0, len = createDebug.skips.length; i < len; i++) {
              if (createDebug.skips[i].test(name)) {
                return false;
              }
            }
            for (i = 0, len = createDebug.names.length; i < len; i++) {
              if (createDebug.names[i].test(name)) {
                return true;
              }
            }
            return false;
          }
          function toNamespace(regexp) {
            return regexp.toString().substring(2, regexp.toString().length - 2).replace(/\.\*\?$/, "*");
          }
          function coerce(val) {
            if (val instanceof Error) {
              return val.stack || val.message;
            }
            return val;
          }
          function destroy() {
            console.warn("Instance method `debug.destroy()` is deprecated and no longer does anything. It will be removed in the next major version of `debug`.");
          }
          createDebug.enable(createDebug.load());
          return createDebug;
        }
        module.exports = setup;
      }
    });

    // node_modules/debug/src/browser.js
    var require_browser$1 = __commonJS$1({
      "node_modules/debug/src/browser.js"(exports, module) {
        exports.formatArgs = formatArgs;
        exports.save = save;
        exports.load = load;
        exports.useColors = useColors;
        exports.storage = localstorage();
        exports.destroy = (() => {
          let warned = false;
          return () => {
            if (!warned) {
              warned = true;
              console.warn("Instance method `debug.destroy()` is deprecated and no longer does anything. It will be removed in the next major version of `debug`.");
            }
          };
        })();
        exports.colors = [
          "#0000CC",
          "#0000FF",
          "#0033CC",
          "#0033FF",
          "#0066CC",
          "#0066FF",
          "#0099CC",
          "#0099FF",
          "#00CC00",
          "#00CC33",
          "#00CC66",
          "#00CC99",
          "#00CCCC",
          "#00CCFF",
          "#3300CC",
          "#3300FF",
          "#3333CC",
          "#3333FF",
          "#3366CC",
          "#3366FF",
          "#3399CC",
          "#3399FF",
          "#33CC00",
          "#33CC33",
          "#33CC66",
          "#33CC99",
          "#33CCCC",
          "#33CCFF",
          "#6600CC",
          "#6600FF",
          "#6633CC",
          "#6633FF",
          "#66CC00",
          "#66CC33",
          "#9900CC",
          "#9900FF",
          "#9933CC",
          "#9933FF",
          "#99CC00",
          "#99CC33",
          "#CC0000",
          "#CC0033",
          "#CC0066",
          "#CC0099",
          "#CC00CC",
          "#CC00FF",
          "#CC3300",
          "#CC3333",
          "#CC3366",
          "#CC3399",
          "#CC33CC",
          "#CC33FF",
          "#CC6600",
          "#CC6633",
          "#CC9900",
          "#CC9933",
          "#CCCC00",
          "#CCCC33",
          "#FF0000",
          "#FF0033",
          "#FF0066",
          "#FF0099",
          "#FF00CC",
          "#FF00FF",
          "#FF3300",
          "#FF3333",
          "#FF3366",
          "#FF3399",
          "#FF33CC",
          "#FF33FF",
          "#FF6600",
          "#FF6633",
          "#FF9900",
          "#FF9933",
          "#FFCC00",
          "#FFCC33"
        ];
        function useColors() {
          if (typeof window !== "undefined" && window.process && (window.process.type === "renderer" || window.process.__nwjs)) {
            return true;
          }
          if (typeof navigator !== "undefined" && navigator.userAgent && navigator.userAgent.toLowerCase().match(/(edge|trident)\/(\d+)/)) {
            return false;
          }
          return typeof document !== "undefined" && document.documentElement && document.documentElement.style && document.documentElement.style.WebkitAppearance || typeof window !== "undefined" && window.console && (window.console.firebug || window.console.exception && window.console.table) || typeof navigator !== "undefined" && navigator.userAgent && navigator.userAgent.toLowerCase().match(/firefox\/(\d+)/) && parseInt(RegExp.$1, 10) >= 31 || typeof navigator !== "undefined" && navigator.userAgent && navigator.userAgent.toLowerCase().match(/applewebkit\/(\d+)/);
        }
        function formatArgs(args) {
          args[0] = (this.useColors ? "%c" : "") + this.namespace + (this.useColors ? " %c" : " ") + args[0] + (this.useColors ? "%c " : " ") + "+" + module.exports.humanize(this.diff);
          if (!this.useColors) {
            return;
          }
          const c = "color: " + this.color;
          args.splice(1, 0, c, "color: inherit");
          let index = 0;
          let lastC = 0;
          args[0].replace(/%[a-zA-Z%]/g, (match) => {
            if (match === "%%") {
              return;
            }
            index++;
            if (match === "%c") {
              lastC = index;
            }
          });
          args.splice(lastC, 0, c);
        }
        exports.log = console.debug || console.log || (() => {
        });
        function save(namespaces) {
          try {
            if (namespaces) {
              exports.storage.setItem("debug", namespaces);
            } else {
              exports.storage.removeItem("debug");
            }
          } catch (error) {
          }
        }
        function load() {
          let r;
          try {
            r = exports.storage.getItem("debug");
          } catch (error) {
          }
          if (!r && false) {
            r = false;
          }
          return r;
        }
        function localstorage() {
          try {
            return localStorage;
          } catch (error) {
          }
        }
        module.exports = require_common()(exports);
        var { formatters } = module.exports;
        formatters.j = function(v) {
          try {
            return JSON.stringify(v);
          } catch (error) {
            return "[UnexpectedJSONParseError]: " + error.message;
          }
        };
      }
    });

    // src/middleware/debug.js
    __toESM$1(require_browser$1());

    // node_modules/capture-stack-trace/index.js
    var require_capture_stack_trace = __commonJS$1({
      "node_modules/capture-stack-trace/index.js"(exports, module) {
        module.exports = Error.captureStackTrace || function(error) {
          var container = new Error();
          Object.defineProperty(error, "stack", {
            configurable: true,
            get: function getStack() {
              var stack = container.stack;
              Object.defineProperty(this, "stack", {
                value: stack
              });
              return stack;
            }
          });
        };
      }
    });

    // node_modules/create-error-class/index.js
    var require_create_error_class = __commonJS$1({
      "node_modules/create-error-class/index.js"(exports, module) {
        var captureStackTrace = require_capture_stack_trace();
        function inherits(ctor, superCtor) {
          ctor.super_ = superCtor;
          ctor.prototype = Object.create(superCtor.prototype, {
            constructor: {
              value: ctor,
              enumerable: false,
              writable: true,
              configurable: true
            }
          });
        }
        module.exports = function createErrorClass2(className, setup) {
          if (typeof className !== "string") {
            throw new TypeError("Expected className to be a string");
          }
          if (/[^0-9a-zA-Z_$]/.test(className)) {
            throw new Error("className contains invalid characters");
          }
          setup = setup || function(message) {
            this.message = message;
          };
          var ErrorClass = function() {
            Object.defineProperty(this, "name", {
              configurable: true,
              value: className,
              writable: true
            });
            captureStackTrace(this, this.constructor);
            setup.apply(this, arguments);
          };
          inherits(ErrorClass, Error);
          return ErrorClass;
        };
      }
    });

    // src/middleware/httpErrors.js
    var import_create_error_class = __toESM$1(require_create_error_class());
    (0, import_create_error_class.default)("HttpError", function(res, ctx) {
      const truncatedUrl = res.url.length > 400 ? `${res.url.slice(0, 399)}\u2026` : res.url;
      let msg = `${res.method}-request to ${truncatedUrl} resulted in `;
      msg += `HTTP ${res.statusCode} ${res.statusMessage}`;
      this.message = msg.trim();
      this.response = res;
      this.request = ctx.options;
    });

    var __create = Object.create;
    var __defProp = Object.defineProperty;
    var __getOwnPropDesc = Object.getOwnPropertyDescriptor;
    var __getOwnPropNames = Object.getOwnPropertyNames;
    var __getProtoOf = Object.getPrototypeOf;
    var __hasOwnProp = Object.prototype.hasOwnProperty;
    var __commonJS = (cb, mod) => function __require() {
      return mod || (0, cb[__getOwnPropNames(cb)[0]])((mod = { exports: {} }).exports, mod), mod.exports;
    };
    var __copyProps = (to, from, except, desc) => {
      if (from && typeof from === "object" || typeof from === "function") {
        for (let key of __getOwnPropNames(from))
          if (!__hasOwnProp.call(to, key) && key !== except)
            __defProp(to, key, { get: () => from[key], enumerable: !(desc = __getOwnPropDesc(from, key)) || desc.enumerable });
      }
      return to;
    };
    var __toESM = (mod, isNodeMode, target) => (target = mod != null ? __create(__getProtoOf(mod)) : {}, __copyProps(
      isNodeMode || !mod || !mod.__esModule ? __defProp(target, "default", { value: mod, enumerable: true }) : target,
      mod
    ));

    // node_modules/event-source-polyfill/src/eventsource.js
    var require_eventsource = __commonJS({
      "node_modules/event-source-polyfill/src/eventsource.js"(exports, module) {
        (function(global) {
          var setTimeout2 = global.setTimeout;
          var clearTimeout2 = global.clearTimeout;
          var XMLHttpRequest = global.XMLHttpRequest;
          var XDomainRequest = global.XDomainRequest;
          var ActiveXObject = global.ActiveXObject;
          var NativeEventSource = global.EventSource;
          var document = global.document;
          var Promise2 = global.Promise;
          var fetch = global.fetch;
          var Response = global.Response;
          var TextDecoder = global.TextDecoder;
          var TextEncoder = global.TextEncoder;
          var AbortController = global.AbortController;
          if (typeof window !== "undefined" && typeof document !== "undefined" && !("readyState" in document) && document.body == null) {
            document.readyState = "loading";
            window.addEventListener("load", function(event) {
              document.readyState = "complete";
            }, false);
          }
          if (XMLHttpRequest == null && ActiveXObject != null) {
            XMLHttpRequest = function() {
              return new ActiveXObject("Microsoft.XMLHTTP");
            };
          }
          if (Object.create == void 0) {
            Object.create = function(C) {
              function F() {
              }
              F.prototype = C;
              return new F();
            };
          }
          if (!Date.now) {
            Date.now = function now() {
              return new Date().getTime();
            };
          }
          if (AbortController == void 0) {
            var originalFetch2 = fetch;
            fetch = function(url, options) {
              var signal = options.signal;
              return originalFetch2(url, { headers: options.headers, credentials: options.credentials, cache: options.cache }).then(function(response) {
                var reader = response.body.getReader();
                signal._reader = reader;
                if (signal._aborted) {
                  signal._reader.cancel();
                }
                return {
                  status: response.status,
                  statusText: response.statusText,
                  headers: response.headers,
                  body: {
                    getReader: function() {
                      return reader;
                    }
                  }
                };
              });
            };
            AbortController = function() {
              this.signal = {
                _reader: null,
                _aborted: false
              };
              this.abort = function() {
                if (this.signal._reader != null) {
                  this.signal._reader.cancel();
                }
                this.signal._aborted = true;
              };
            };
          }
          function TextDecoderPolyfill() {
            this.bitsNeeded = 0;
            this.codePoint = 0;
          }
          TextDecoderPolyfill.prototype.decode = function(octets) {
            function valid(codePoint2, shift, octetsCount2) {
              if (octetsCount2 === 1) {
                return codePoint2 >= 128 >> shift && codePoint2 << shift <= 2047;
              }
              if (octetsCount2 === 2) {
                return codePoint2 >= 2048 >> shift && codePoint2 << shift <= 55295 || codePoint2 >= 57344 >> shift && codePoint2 << shift <= 65535;
              }
              if (octetsCount2 === 3) {
                return codePoint2 >= 65536 >> shift && codePoint2 << shift <= 1114111;
              }
              throw new Error();
            }
            function octetsCount(bitsNeeded2, codePoint2) {
              if (bitsNeeded2 === 6 * 1) {
                return codePoint2 >> 6 > 15 ? 3 : codePoint2 > 31 ? 2 : 1;
              }
              if (bitsNeeded2 === 6 * 2) {
                return codePoint2 > 15 ? 3 : 2;
              }
              if (bitsNeeded2 === 6 * 3) {
                return 3;
              }
              throw new Error();
            }
            var REPLACER = 65533;
            var string = "";
            var bitsNeeded = this.bitsNeeded;
            var codePoint = this.codePoint;
            for (var i = 0; i < octets.length; i += 1) {
              var octet = octets[i];
              if (bitsNeeded !== 0) {
                if (octet < 128 || octet > 191 || !valid(codePoint << 6 | octet & 63, bitsNeeded - 6, octetsCount(bitsNeeded, codePoint))) {
                  bitsNeeded = 0;
                  codePoint = REPLACER;
                  string += String.fromCharCode(codePoint);
                }
              }
              if (bitsNeeded === 0) {
                if (octet >= 0 && octet <= 127) {
                  bitsNeeded = 0;
                  codePoint = octet;
                } else if (octet >= 192 && octet <= 223) {
                  bitsNeeded = 6 * 1;
                  codePoint = octet & 31;
                } else if (octet >= 224 && octet <= 239) {
                  bitsNeeded = 6 * 2;
                  codePoint = octet & 15;
                } else if (octet >= 240 && octet <= 247) {
                  bitsNeeded = 6 * 3;
                  codePoint = octet & 7;
                } else {
                  bitsNeeded = 0;
                  codePoint = REPLACER;
                }
                if (bitsNeeded !== 0 && !valid(codePoint, bitsNeeded, octetsCount(bitsNeeded, codePoint))) {
                  bitsNeeded = 0;
                  codePoint = REPLACER;
                }
              } else {
                bitsNeeded -= 6;
                codePoint = codePoint << 6 | octet & 63;
              }
              if (bitsNeeded === 0) {
                if (codePoint <= 65535) {
                  string += String.fromCharCode(codePoint);
                } else {
                  string += String.fromCharCode(55296 + (codePoint - 65535 - 1 >> 10));
                  string += String.fromCharCode(56320 + (codePoint - 65535 - 1 & 1023));
                }
              }
            }
            this.bitsNeeded = bitsNeeded;
            this.codePoint = codePoint;
            return string;
          };
          var supportsStreamOption = function() {
            try {
              return new TextDecoder().decode(new TextEncoder().encode("test"), { stream: true }) === "test";
            } catch (error) {
              console.debug("TextDecoder does not support streaming option. Using polyfill instead: " + error);
            }
            return false;
          };
          if (TextDecoder == void 0 || TextEncoder == void 0 || !supportsStreamOption()) {
            TextDecoder = TextDecoderPolyfill;
          }
          var k = function() {
          };
          function XHRWrapper(xhr) {
            this.withCredentials = false;
            this.readyState = 0;
            this.status = 0;
            this.statusText = "";
            this.responseText = "";
            this.onprogress = k;
            this.onload = k;
            this.onerror = k;
            this.onreadystatechange = k;
            this._contentType = "";
            this._xhr = xhr;
            this._sendTimeout = 0;
            this._abort = k;
          }
          XHRWrapper.prototype.open = function(method, url) {
            this._abort(true);
            var that = this;
            var xhr = this._xhr;
            var state = 1;
            var timeout = 0;
            this._abort = function(silent) {
              if (that._sendTimeout !== 0) {
                clearTimeout2(that._sendTimeout);
                that._sendTimeout = 0;
              }
              if (state === 1 || state === 2 || state === 3) {
                state = 4;
                xhr.onload = k;
                xhr.onerror = k;
                xhr.onabort = k;
                xhr.onprogress = k;
                xhr.onreadystatechange = k;
                xhr.abort();
                if (timeout !== 0) {
                  clearTimeout2(timeout);
                  timeout = 0;
                }
                if (!silent) {
                  that.readyState = 4;
                  that.onabort(null);
                  that.onreadystatechange();
                }
              }
              state = 0;
            };
            var onStart = function() {
              if (state === 1) {
                var status = 0;
                var statusText = "";
                var contentType = void 0;
                if (!("contentType" in xhr)) {
                  try {
                    status = xhr.status;
                    statusText = xhr.statusText;
                    contentType = xhr.getResponseHeader("Content-Type");
                  } catch (error) {
                    status = 0;
                    statusText = "";
                    contentType = void 0;
                  }
                } else {
                  status = 200;
                  statusText = "OK";
                  contentType = xhr.contentType;
                }
                if (status !== 0) {
                  state = 2;
                  that.readyState = 2;
                  that.status = status;
                  that.statusText = statusText;
                  that._contentType = contentType;
                  that.onreadystatechange();
                }
              }
            };
            var onProgress = function() {
              onStart();
              if (state === 2 || state === 3) {
                state = 3;
                var responseText = "";
                try {
                  responseText = xhr.responseText;
                } catch (error) {
                }
                that.readyState = 3;
                that.responseText = responseText;
                that.onprogress();
              }
            };
            var onFinish = function(type, event) {
              if (event == null || event.preventDefault == null) {
                event = {
                  preventDefault: k
                };
              }
              onProgress();
              if (state === 1 || state === 2 || state === 3) {
                state = 4;
                if (timeout !== 0) {
                  clearTimeout2(timeout);
                  timeout = 0;
                }
                that.readyState = 4;
                if (type === "load") {
                  that.onload(event);
                } else if (type === "error") {
                  that.onerror(event);
                } else if (type === "abort") {
                  that.onabort(event);
                } else {
                  throw new TypeError();
                }
                that.onreadystatechange();
              }
            };
            var onReadyStateChange = function(event) {
              if (xhr != void 0) {
                if (xhr.readyState === 4) {
                  if (!("onload" in xhr) || !("onerror" in xhr) || !("onabort" in xhr)) {
                    onFinish(xhr.responseText === "" ? "error" : "load", event);
                  }
                } else if (xhr.readyState === 3) {
                  if (!("onprogress" in xhr)) {
                    onProgress();
                  }
                } else if (xhr.readyState === 2) {
                  onStart();
                }
              }
            };
            var onTimeout = function() {
              timeout = setTimeout2(function() {
                onTimeout();
              }, 500);
              if (xhr.readyState === 3) {
                onProgress();
              }
            };
            if ("onload" in xhr) {
              xhr.onload = function(event) {
                onFinish("load", event);
              };
            }
            if ("onerror" in xhr) {
              xhr.onerror = function(event) {
                onFinish("error", event);
              };
            }
            if ("onabort" in xhr) {
              xhr.onabort = function(event) {
                onFinish("abort", event);
              };
            }
            if ("onprogress" in xhr) {
              xhr.onprogress = onProgress;
            }
            if ("onreadystatechange" in xhr) {
              xhr.onreadystatechange = function(event) {
                onReadyStateChange(event);
              };
            }
            if ("contentType" in xhr || !("ontimeout" in XMLHttpRequest.prototype)) {
              url += (url.indexOf("?") === -1 ? "?" : "&") + "padding=true";
            }
            xhr.open(method, url, true);
            if ("readyState" in xhr) {
              timeout = setTimeout2(function() {
                onTimeout();
              }, 0);
            }
          };
          XHRWrapper.prototype.abort = function() {
            this._abort(false);
          };
          XHRWrapper.prototype.getResponseHeader = function(name) {
            return this._contentType;
          };
          XHRWrapper.prototype.setRequestHeader = function(name, value) {
            var xhr = this._xhr;
            if ("setRequestHeader" in xhr) {
              xhr.setRequestHeader(name, value);
            }
          };
          XHRWrapper.prototype.getAllResponseHeaders = function() {
            return this._xhr.getAllResponseHeaders != void 0 ? this._xhr.getAllResponseHeaders() || "" : "";
          };
          XHRWrapper.prototype.send = function() {
            if ((!("ontimeout" in XMLHttpRequest.prototype) || !("sendAsBinary" in XMLHttpRequest.prototype) && !("mozAnon" in XMLHttpRequest.prototype)) && document != void 0 && document.readyState != void 0 && document.readyState !== "complete") {
              var that = this;
              that._sendTimeout = setTimeout2(function() {
                that._sendTimeout = 0;
                that.send();
              }, 4);
              return;
            }
            var xhr = this._xhr;
            if ("withCredentials" in xhr) {
              xhr.withCredentials = this.withCredentials;
            }
            try {
              xhr.send(void 0);
            } catch (error1) {
              throw error1;
            }
          };
          function toLowerCase(name) {
            return name.replace(/[A-Z]/g, function(c) {
              return String.fromCharCode(c.charCodeAt(0) + 32);
            });
          }
          function HeadersPolyfill(all) {
            var map2 = /* @__PURE__ */ Object.create(null);
            var array = all.split("\r\n");
            for (var i = 0; i < array.length; i += 1) {
              var line = array[i];
              var parts = line.split(": ");
              var name = parts.shift();
              var value = parts.join(": ");
              map2[toLowerCase(name)] = value;
            }
            this._map = map2;
          }
          HeadersPolyfill.prototype.get = function(name) {
            return this._map[toLowerCase(name)];
          };
          if (XMLHttpRequest != null && XMLHttpRequest.HEADERS_RECEIVED == null) {
            XMLHttpRequest.HEADERS_RECEIVED = 2;
          }
          function XHRTransport() {
          }
          XHRTransport.prototype.open = function(xhr, onStartCallback, onProgressCallback, onFinishCallback, url, withCredentials, headers) {
            xhr.open("GET", url);
            var offset = 0;
            xhr.onprogress = function() {
              var responseText = xhr.responseText;
              var chunk = responseText.slice(offset);
              offset += chunk.length;
              onProgressCallback(chunk);
            };
            xhr.onerror = function(event) {
              event.preventDefault();
              onFinishCallback(new Error("NetworkError"));
            };
            xhr.onload = function() {
              onFinishCallback(null);
            };
            xhr.onabort = function() {
              onFinishCallback(null);
            };
            xhr.onreadystatechange = function() {
              if (xhr.readyState === XMLHttpRequest.HEADERS_RECEIVED) {
                var status = xhr.status;
                var statusText = xhr.statusText;
                var contentType = xhr.getResponseHeader("Content-Type");
                var headers2 = xhr.getAllResponseHeaders();
                onStartCallback(status, statusText, contentType, new HeadersPolyfill(headers2));
              }
            };
            xhr.withCredentials = withCredentials;
            for (var name in headers) {
              if (Object.prototype.hasOwnProperty.call(headers, name)) {
                xhr.setRequestHeader(name, headers[name]);
              }
            }
            xhr.send();
            return xhr;
          };
          function HeadersWrapper(headers) {
            this._headers = headers;
          }
          HeadersWrapper.prototype.get = function(name) {
            return this._headers.get(name);
          };
          function FetchTransport() {
          }
          FetchTransport.prototype.open = function(xhr, onStartCallback, onProgressCallback, onFinishCallback, url, withCredentials, headers) {
            var reader = null;
            var controller = new AbortController();
            var signal = controller.signal;
            var textDecoder = new TextDecoder();
            fetch(url, {
              headers,
              credentials: withCredentials ? "include" : "same-origin",
              signal,
              cache: "no-store"
            }).then(function(response) {
              reader = response.body.getReader();
              onStartCallback(response.status, response.statusText, response.headers.get("Content-Type"), new HeadersWrapper(response.headers));
              return new Promise2(function(resolve, reject) {
                var readNextChunk = function() {
                  reader.read().then(function(result) {
                    if (result.done) {
                      resolve(void 0);
                    } else {
                      var chunk = textDecoder.decode(result.value, { stream: true });
                      onProgressCallback(chunk);
                      readNextChunk();
                    }
                  })["catch"](function(error) {
                    reject(error);
                  });
                };
                readNextChunk();
              });
            })["catch"](function(error) {
              if (error.name === "AbortError") {
                return void 0;
              } else {
                return error;
              }
            }).then(function(error) {
              onFinishCallback(error);
            });
            return {
              abort: function() {
                if (reader != null) {
                  reader.cancel();
                }
                controller.abort();
              }
            };
          };
          function EventTarget() {
            this._listeners = /* @__PURE__ */ Object.create(null);
          }
          function throwError(e) {
            setTimeout2(function() {
              throw e;
            }, 0);
          }
          EventTarget.prototype.dispatchEvent = function(event) {
            event.target = this;
            var typeListeners = this._listeners[event.type];
            if (typeListeners != void 0) {
              var length = typeListeners.length;
              for (var i = 0; i < length; i += 1) {
                var listener = typeListeners[i];
                try {
                  if (typeof listener.handleEvent === "function") {
                    listener.handleEvent(event);
                  } else {
                    listener.call(this, event);
                  }
                } catch (e) {
                  throwError(e);
                }
              }
            }
          };
          EventTarget.prototype.addEventListener = function(type, listener) {
            type = String(type);
            var listeners = this._listeners;
            var typeListeners = listeners[type];
            if (typeListeners == void 0) {
              typeListeners = [];
              listeners[type] = typeListeners;
            }
            var found = false;
            for (var i = 0; i < typeListeners.length; i += 1) {
              if (typeListeners[i] === listener) {
                found = true;
              }
            }
            if (!found) {
              typeListeners.push(listener);
            }
          };
          EventTarget.prototype.removeEventListener = function(type, listener) {
            type = String(type);
            var listeners = this._listeners;
            var typeListeners = listeners[type];
            if (typeListeners != void 0) {
              var filtered = [];
              for (var i = 0; i < typeListeners.length; i += 1) {
                if (typeListeners[i] !== listener) {
                  filtered.push(typeListeners[i]);
                }
              }
              if (filtered.length === 0) {
                delete listeners[type];
              } else {
                listeners[type] = filtered;
              }
            }
          };
          function Event(type) {
            this.type = type;
            this.target = void 0;
          }
          function MessageEvent(type, options) {
            Event.call(this, type);
            this.data = options.data;
            this.lastEventId = options.lastEventId;
          }
          MessageEvent.prototype = Object.create(Event.prototype);
          function ConnectionEvent(type, options) {
            Event.call(this, type);
            this.status = options.status;
            this.statusText = options.statusText;
            this.headers = options.headers;
          }
          ConnectionEvent.prototype = Object.create(Event.prototype);
          function ErrorEvent(type, options) {
            Event.call(this, type);
            this.error = options.error;
          }
          ErrorEvent.prototype = Object.create(Event.prototype);
          var WAITING = -1;
          var CONNECTING = 0;
          var OPEN = 1;
          var CLOSED = 2;
          var AFTER_CR = -1;
          var FIELD_START = 0;
          var FIELD = 1;
          var VALUE_START = 2;
          var VALUE = 3;
          var contentTypeRegExp = /^text\/event\-stream(;.*)?$/i;
          var MINIMUM_DURATION = 1e3;
          var MAXIMUM_DURATION = 18e6;
          var parseDuration = function(value, def) {
            var n = value == null ? def : parseInt(value, 10);
            if (n !== n) {
              n = def;
            }
            return clampDuration(n);
          };
          var clampDuration = function(n) {
            return Math.min(Math.max(n, MINIMUM_DURATION), MAXIMUM_DURATION);
          };
          var fire = function(that, f, event) {
            try {
              if (typeof f === "function") {
                f.call(that, event);
              }
            } catch (e) {
              throwError(e);
            }
          };
          function EventSourcePolyfill(url, options) {
            EventTarget.call(this);
            options = options || {};
            this.onopen = void 0;
            this.onmessage = void 0;
            this.onerror = void 0;
            this.url = void 0;
            this.readyState = void 0;
            this.withCredentials = void 0;
            this.headers = void 0;
            this._close = void 0;
            start(this, url, options);
          }
          function getBestXHRTransport() {
            return XMLHttpRequest != void 0 && "withCredentials" in XMLHttpRequest.prototype || XDomainRequest == void 0 ? new XMLHttpRequest() : new XDomainRequest();
          }
          var isFetchSupported = fetch != void 0 && Response != void 0 && "body" in Response.prototype;
          function start(es, url, options) {
            url = String(url);
            var withCredentials = Boolean(options.withCredentials);
            var lastEventIdQueryParameterName = options.lastEventIdQueryParameterName || "lastEventId";
            var initialRetry = clampDuration(1e3);
            var heartbeatTimeout = parseDuration(options.heartbeatTimeout, 45e3);
            var lastEventId = "";
            var retry = initialRetry;
            var wasActivity = false;
            var textLength = 0;
            var headers = options.headers || {};
            var TransportOption = options.Transport;
            var xhr = isFetchSupported && TransportOption == void 0 ? void 0 : new XHRWrapper(TransportOption != void 0 ? new TransportOption() : getBestXHRTransport());
            var transport = TransportOption != null && typeof TransportOption !== "string" ? new TransportOption() : xhr == void 0 ? new FetchTransport() : new XHRTransport();
            var abortController = void 0;
            var timeout = 0;
            var currentState = WAITING;
            var dataBuffer = "";
            var lastEventIdBuffer = "";
            var eventTypeBuffer = "";
            var textBuffer = "";
            var state = FIELD_START;
            var fieldStart = 0;
            var valueStart = 0;
            var onStart = function(status, statusText, contentType, headers2) {
              if (currentState === CONNECTING) {
                if (status === 200 && contentType != void 0 && contentTypeRegExp.test(contentType)) {
                  currentState = OPEN;
                  wasActivity = Date.now();
                  retry = initialRetry;
                  es.readyState = OPEN;
                  var event = new ConnectionEvent("open", {
                    status,
                    statusText,
                    headers: headers2
                  });
                  es.dispatchEvent(event);
                  fire(es, es.onopen, event);
                } else {
                  var message = "";
                  if (status !== 200) {
                    if (statusText) {
                      statusText = statusText.replace(/\s+/g, " ");
                    }
                    message = "EventSource's response has a status " + status + " " + statusText + " that is not 200. Aborting the connection.";
                  } else {
                    message = "EventSource's response has a Content-Type specifying an unsupported type: " + (contentType == void 0 ? "-" : contentType.replace(/\s+/g, " ")) + ". Aborting the connection.";
                  }
                  close();
                  var event = new ConnectionEvent("error", {
                    status,
                    statusText,
                    headers: headers2
                  });
                  es.dispatchEvent(event);
                  fire(es, es.onerror, event);
                  console.error(message);
                }
              }
            };
            var onProgress = function(textChunk) {
              if (currentState === OPEN) {
                var n = -1;
                for (var i = 0; i < textChunk.length; i += 1) {
                  var c = textChunk.charCodeAt(i);
                  if (c === "\n".charCodeAt(0) || c === "\r".charCodeAt(0)) {
                    n = i;
                  }
                }
                var chunk = (n !== -1 ? textBuffer : "") + textChunk.slice(0, n + 1);
                textBuffer = (n === -1 ? textBuffer : "") + textChunk.slice(n + 1);
                if (textChunk !== "") {
                  wasActivity = Date.now();
                  textLength += textChunk.length;
                }
                for (var position = 0; position < chunk.length; position += 1) {
                  var c = chunk.charCodeAt(position);
                  if (state === AFTER_CR && c === "\n".charCodeAt(0)) {
                    state = FIELD_START;
                  } else {
                    if (state === AFTER_CR) {
                      state = FIELD_START;
                    }
                    if (c === "\r".charCodeAt(0) || c === "\n".charCodeAt(0)) {
                      if (state !== FIELD_START) {
                        if (state === FIELD) {
                          valueStart = position + 1;
                        }
                        var field = chunk.slice(fieldStart, valueStart - 1);
                        var value = chunk.slice(valueStart + (valueStart < position && chunk.charCodeAt(valueStart) === " ".charCodeAt(0) ? 1 : 0), position);
                        if (field === "data") {
                          dataBuffer += "\n";
                          dataBuffer += value;
                        } else if (field === "id") {
                          lastEventIdBuffer = value;
                        } else if (field === "event") {
                          eventTypeBuffer = value;
                        } else if (field === "retry") {
                          initialRetry = parseDuration(value, initialRetry);
                          retry = initialRetry;
                        } else if (field === "heartbeatTimeout") {
                          heartbeatTimeout = parseDuration(value, heartbeatTimeout);
                          if (timeout !== 0) {
                            clearTimeout2(timeout);
                            timeout = setTimeout2(function() {
                              onTimeout();
                            }, heartbeatTimeout);
                          }
                        }
                      }
                      if (state === FIELD_START) {
                        if (dataBuffer !== "") {
                          lastEventId = lastEventIdBuffer;
                          if (eventTypeBuffer === "") {
                            eventTypeBuffer = "message";
                          }
                          var event = new MessageEvent(eventTypeBuffer, {
                            data: dataBuffer.slice(1),
                            lastEventId: lastEventIdBuffer
                          });
                          es.dispatchEvent(event);
                          if (eventTypeBuffer === "open") {
                            fire(es, es.onopen, event);
                          } else if (eventTypeBuffer === "message") {
                            fire(es, es.onmessage, event);
                          } else if (eventTypeBuffer === "error") {
                            fire(es, es.onerror, event);
                          }
                          if (currentState === CLOSED) {
                            return;
                          }
                        }
                        dataBuffer = "";
                        eventTypeBuffer = "";
                      }
                      state = c === "\r".charCodeAt(0) ? AFTER_CR : FIELD_START;
                    } else {
                      if (state === FIELD_START) {
                        fieldStart = position;
                        state = FIELD;
                      }
                      if (state === FIELD) {
                        if (c === ":".charCodeAt(0)) {
                          valueStart = position + 1;
                          state = VALUE_START;
                        }
                      } else if (state === VALUE_START) {
                        state = VALUE;
                      }
                    }
                  }
                }
              }
            };
            var onFinish = function(error) {
              if (currentState === OPEN || currentState === CONNECTING) {
                currentState = WAITING;
                if (timeout !== 0) {
                  clearTimeout2(timeout);
                  timeout = 0;
                }
                timeout = setTimeout2(function() {
                  onTimeout();
                }, retry);
                retry = clampDuration(Math.min(initialRetry * 16, retry * 2));
                es.readyState = CONNECTING;
                var event = new ErrorEvent("error", { error });
                es.dispatchEvent(event);
                fire(es, es.onerror, event);
                if (error != void 0) {
                  console.error(error);
                }
              }
            };
            var close = function() {
              currentState = CLOSED;
              if (abortController != void 0) {
                abortController.abort();
                abortController = void 0;
              }
              if (timeout !== 0) {
                clearTimeout2(timeout);
                timeout = 0;
              }
              es.readyState = CLOSED;
            };
            var onTimeout = function() {
              timeout = 0;
              if (currentState !== WAITING) {
                if (!wasActivity && abortController != void 0) {
                  onFinish(new Error("No activity within " + heartbeatTimeout + " milliseconds. " + (currentState === CONNECTING ? "No response received." : textLength + " chars received.") + " Reconnecting."));
                  if (abortController != void 0) {
                    abortController.abort();
                    abortController = void 0;
                  }
                } else {
                  var nextHeartbeat = Math.max((wasActivity || Date.now()) + heartbeatTimeout - Date.now(), 1);
                  wasActivity = false;
                  timeout = setTimeout2(function() {
                    onTimeout();
                  }, nextHeartbeat);
                }
                return;
              }
              wasActivity = false;
              textLength = 0;
              timeout = setTimeout2(function() {
                onTimeout();
              }, heartbeatTimeout);
              currentState = CONNECTING;
              dataBuffer = "";
              eventTypeBuffer = "";
              lastEventIdBuffer = lastEventId;
              textBuffer = "";
              fieldStart = 0;
              valueStart = 0;
              state = FIELD_START;
              var requestURL = url;
              if (url.slice(0, 5) !== "data:" && url.slice(0, 5) !== "blob:") {
                if (lastEventId !== "") {
                  var i = url.indexOf("?");
                  requestURL = i === -1 ? url : url.slice(0, i + 1) + url.slice(i + 1).replace(/(?:^|&)([^=&]*)(?:=[^&]*)?/g, function(p, paramName) {
                    return paramName === lastEventIdQueryParameterName ? "" : p;
                  });
                  requestURL += (url.indexOf("?") === -1 ? "?" : "&") + lastEventIdQueryParameterName + "=" + encodeURIComponent(lastEventId);
                }
              }
              var withCredentials2 = es.withCredentials;
              var requestHeaders = {};
              requestHeaders["Accept"] = "text/event-stream";
              var headers2 = es.headers;
              if (headers2 != void 0) {
                for (var name in headers2) {
                  if (Object.prototype.hasOwnProperty.call(headers2, name)) {
                    requestHeaders[name] = headers2[name];
                  }
                }
              }
              try {
                abortController = transport.open(xhr, onStart, onProgress, onFinish, requestURL, withCredentials2, requestHeaders);
              } catch (error) {
                close();
                throw error;
              }
            };
            es.url = url;
            es.readyState = CONNECTING;
            es.withCredentials = withCredentials;
            es.headers = headers;
            es._close = close;
            onTimeout();
          }
          EventSourcePolyfill.prototype = Object.create(EventTarget.prototype);
          EventSourcePolyfill.prototype.CONNECTING = CONNECTING;
          EventSourcePolyfill.prototype.OPEN = OPEN;
          EventSourcePolyfill.prototype.CLOSED = CLOSED;
          EventSourcePolyfill.prototype.close = function() {
            this._close();
          };
          EventSourcePolyfill.CONNECTING = CONNECTING;
          EventSourcePolyfill.OPEN = OPEN;
          EventSourcePolyfill.CLOSED = CLOSED;
          EventSourcePolyfill.prototype.withCredentials = void 0;
          var R = NativeEventSource;
          if (XMLHttpRequest != void 0 && (NativeEventSource == void 0 || !("withCredentials" in NativeEventSource.prototype))) {
            R = EventSourcePolyfill;
          }
          (function(factory) {
            if (typeof module === "object" && typeof module.exports === "object") {
              var v = factory(exports);
              if (v !== void 0)
                module.exports = v;
            } else if (typeof define === "function" && define.amd) {
              define(["exports"], factory);
            } else {
              factory(global);
            }
          })(function(exports2) {
            exports2.EventSourcePolyfill = EventSourcePolyfill;
            exports2.NativeEventSource = NativeEventSource;
            exports2.EventSource = R;
          });
        })(typeof globalThis === "undefined" ? typeof window !== "undefined" ? window : typeof self !== "undefined" ? self : exports : globalThis);
      }
    });

    // node_modules/@sanity/eventsource/browser.js
    var require_browser = __commonJS({
      "node_modules/@sanity/eventsource/browser.js"(exports, module) {
        var evs = require_eventsource();
        module.exports = evs.EventSourcePolyfill;
      }
    });

    // node_modules/make-error/index.js
    var require_make_error = __commonJS({
      "node_modules/make-error/index.js"(exports, module) {
        var construct = typeof Reflect !== "undefined" ? Reflect.construct : void 0;
        var defineProperty = Object.defineProperty;
        var captureStackTrace = Error.captureStackTrace;
        if (captureStackTrace === void 0) {
          captureStackTrace = function captureStackTrace2(error) {
            var container = new Error();
            defineProperty(error, "stack", {
              configurable: true,
              get: function getStack() {
                var stack = container.stack;
                defineProperty(this, "stack", {
                  configurable: true,
                  value: stack,
                  writable: true
                });
                return stack;
              },
              set: function setStack(stack) {
                defineProperty(error, "stack", {
                  configurable: true,
                  value: stack,
                  writable: true
                });
              }
            });
          };
        }
        function BaseError(message) {
          if (message !== void 0) {
            defineProperty(this, "message", {
              configurable: true,
              value: message,
              writable: true
            });
          }
          var cname = this.constructor.name;
          if (cname !== void 0 && cname !== this.name) {
            defineProperty(this, "name", {
              configurable: true,
              value: cname,
              writable: true
            });
          }
          captureStackTrace(this, this.constructor);
        }
        BaseError.prototype = Object.create(Error.prototype, {
          constructor: {
            configurable: true,
            value: BaseError,
            writable: true
          }
        });
        var setFunctionName = function() {
          function setFunctionName2(fn, name) {
            return defineProperty(fn, "name", {
              configurable: true,
              value: name
            });
          }
          try {
            var f = function() {
            };
            setFunctionName2(f, "foo");
            if (f.name === "foo") {
              return setFunctionName2;
            }
          } catch (_) {
          }
        }();
        function makeError2(constructor, super_) {
          if (super_ == null || super_ === Error) {
            super_ = BaseError;
          } else if (typeof super_ !== "function") {
            throw new TypeError("super_ should be a function");
          }
          var name;
          if (typeof constructor === "string") {
            name = constructor;
            constructor = construct !== void 0 ? function() {
              return construct(super_, arguments, this.constructor);
            } : function() {
              super_.apply(this, arguments);
            };
            if (setFunctionName !== void 0) {
              setFunctionName(constructor, name);
              name = void 0;
            }
          } else if (typeof constructor !== "function") {
            throw new TypeError("constructor should be either a string or a function");
          }
          constructor.super_ = constructor["super"] = super_;
          var properties = {
            constructor: {
              configurable: true,
              value: constructor,
              writable: true
            }
          };
          if (name !== void 0) {
            properties.name = {
              configurable: true,
              value: name,
              writable: true
            };
          }
          constructor.prototype = Object.create(super_.prototype, properties);
          return constructor;
        }
        exports = module.exports = makeError2;
        exports.BaseError = BaseError;
      }
    });

    // src/util/getSelection.js
    function getSelection(sel) {
      if (typeof sel === "string" || Array.isArray(sel)) {
        return { id: sel };
      }
      if (sel && sel.query) {
        return "params" in sel ? { query: sel.query, params: sel.params } : { query: sel.query };
      }
      const selectionOpts = [
        "* Document ID (<docId>)",
        "* Array of document IDs",
        "* Object containing `query`"
      ].join("\n");
      throw new Error(`Unknown selection - must be one of:

${selectionOpts}`);
    }

    // src/validators.js
    var VALID_ASSET_TYPES = ["image", "file"];
    var VALID_INSERT_LOCATIONS = ["before", "after", "replace"];
    var dataset = (name) => {
      if (!/^(~[a-z0-9]{1}[-\w]{0,63}|[a-z0-9]{1}[-\w]{0,63})$/.test(name)) {
        throw new Error(
          "Datasets can only contain lowercase characters, numbers, underscores and dashes, and start with tilde, and be maximum 64 characters"
        );
      }
    };
    var projectId = (id) => {
      if (!/^[-a-z0-9]+$/i.test(id)) {
        throw new Error("`projectId` can only contain only a-z, 0-9 and dashes");
      }
    };
    var validateAssetType = (type) => {
      if (VALID_ASSET_TYPES.indexOf(type) === -1) {
        throw new Error(`Invalid asset type: ${type}. Must be one of ${VALID_ASSET_TYPES.join(", ")}`);
      }
    };
    var validateObject = (op, val) => {
      if (val === null || typeof val !== "object" || Array.isArray(val)) {
        throw new Error(`${op}() takes an object of properties`);
      }
    };
    var validateDocumentId = (op, id) => {
      if (typeof id !== "string" || !/^[a-z0-9_.-]+$/i.test(id)) {
        throw new Error(`${op}(): "${id}" is not a valid document ID`);
      }
    };
    var requireDocumentId = (op, doc) => {
      if (!doc._id) {
        throw new Error(`${op}() requires that the document contains an ID ("_id" property)`);
      }
      validateDocumentId(op, doc._id);
    };
    var validateInsert = (at, selector, items) => {
      const signature = "insert(at, selector, items)";
      if (VALID_INSERT_LOCATIONS.indexOf(at) === -1) {
        const valid = VALID_INSERT_LOCATIONS.map((loc) => `"${loc}"`).join(", ");
        throw new Error(`${signature} takes an "at"-argument which is one of: ${valid}`);
      }
      if (typeof selector !== "string") {
        throw new Error(`${signature} takes a "selector"-argument which must be a string`);
      }
      if (!Array.isArray(items)) {
        throw new Error(`${signature} takes an "items"-argument which must be an array`);
      }
    };
    var hasDataset = (config2) => {
      if (!config2.dataset) {
        throw new Error("`dataset` must be provided to perform queries");
      }
      return config2.dataset || "";
    };
    var requestTag = (tag) => {
      if (typeof tag !== "string" || !/^[a-z0-9._-]{1,75}$/i.test(tag)) {
        throw new Error(
          `Tag can only contain alphanumeric characters, underscores, dashes and dots, and be between one and 75 characters long.`
        );
      }
      return tag;
    };

    // src/data/patch.js
    function Patch(selection, operations = {}, client = null) {
      this.selection = selection;
      this.operations = Object.assign({}, operations);
      this.client = client;
    }
    Object.assign(Patch.prototype, {
      clone() {
        return new Patch(this.selection, Object.assign({}, this.operations), this.client);
      },
      set(props) {
        return this.assign("set", props);
      },
      diffMatchPatch(props) {
        validateObject("diffMatchPatch", props);
        return this.assign("diffMatchPatch", props);
      },
      unset(attrs) {
        if (!Array.isArray(attrs)) {
          throw new Error("unset(attrs) takes an array of attributes to unset, non-array given");
        }
        this.operations = Object.assign({}, this.operations, { unset: attrs });
        return this;
      },
      setIfMissing(props) {
        return this.assign("setIfMissing", props);
      },
      replace(props) {
        validateObject("replace", props);
        return this._set("set", { $: props });
      },
      inc(props) {
        return this.assign("inc", props);
      },
      dec(props) {
        return this.assign("dec", props);
      },
      insert(at, selector, items) {
        validateInsert(at, selector, items);
        return this.assign("insert", { [at]: selector, items });
      },
      append(selector, items) {
        return this.insert("after", `${selector}[-1]`, items);
      },
      prepend(selector, items) {
        return this.insert("before", `${selector}[0]`, items);
      },
      splice(selector, start, deleteCount, items) {
        const delAll = typeof deleteCount === "undefined" || deleteCount === -1;
        const startIndex = start < 0 ? start - 1 : start;
        const delCount = delAll ? -1 : Math.max(0, start + deleteCount);
        const delRange = startIndex < 0 && delCount >= 0 ? "" : delCount;
        const rangeSelector = `${selector}[${startIndex}:${delRange}]`;
        return this.insert("replace", rangeSelector, items || []);
      },
      ifRevisionId(rev) {
        this.operations.ifRevisionID = rev;
        return this;
      },
      serialize() {
        return Object.assign(getSelection(this.selection), this.operations);
      },
      toJSON() {
        return this.serialize();
      },
      commit(options = {}) {
        if (!this.client) {
          throw new Error(
            "No `client` passed to patch, either provide one or pass the patch to a clients `mutate()` method"
          );
        }
        const returnFirst = typeof this.selection === "string";
        const opts = Object.assign({ returnFirst, returnDocuments: true }, options);
        return this.client.mutate({ patch: this.serialize() }, opts);
      },
      reset() {
        this.operations = {};
        return this;
      },
      _set(op, props) {
        return this.assign(op, props, false);
      },
      assign(op, props, merge = true) {
        validateObject(op, props);
        this.operations = Object.assign({}, this.operations, {
          [op]: Object.assign({}, merge && this.operations[op] || {}, props)
        });
        return this;
      }
    });
    var patch_default = Patch;

    // src/data/transaction.js
    var defaultMutateOptions = { returnDocuments: false };
    function Transaction(operations = [], client, transactionId) {
      this.trxId = transactionId;
      this.operations = operations;
      this.client = client;
    }
    Object.assign(Transaction.prototype, {
      clone() {
        return new Transaction(this.operations.slice(0), this.client, this.trxId);
      },
      create(doc) {
        validateObject("create", doc);
        return this._add({ create: doc });
      },
      createIfNotExists(doc) {
        const op = "createIfNotExists";
        validateObject(op, doc);
        requireDocumentId(op, doc);
        return this._add({ [op]: doc });
      },
      createOrReplace(doc) {
        const op = "createOrReplace";
        validateObject(op, doc);
        requireDocumentId(op, doc);
        return this._add({ [op]: doc });
      },
      delete(documentId) {
        validateDocumentId("delete", documentId);
        return this._add({ delete: { id: documentId } });
      },
      patch(documentId, patchOps) {
        const isBuilder = typeof patchOps === "function";
        const isPatch = documentId instanceof patch_default;
        if (isPatch) {
          return this._add({ patch: documentId.serialize() });
        }
        if (isBuilder) {
          const patch = patchOps(new patch_default(documentId, {}, this.client));
          if (!(patch instanceof patch_default)) {
            throw new Error("function passed to `patch()` must return the patch");
          }
          return this._add({ patch: patch.serialize() });
        }
        return this._add({ patch: Object.assign({ id: documentId }, patchOps) });
      },
      transactionId(id) {
        if (!id) {
          return this.trxId;
        }
        this.trxId = id;
        return this;
      },
      serialize() {
        return this.operations.slice();
      },
      toJSON() {
        return this.serialize();
      },
      commit(options) {
        if (!this.client) {
          throw new Error(
            "No `client` passed to transaction, either provide one or pass the transaction to a clients `mutate()` method"
          );
        }
        return this.client.mutate(
          this.serialize(),
          Object.assign({ transactionId: this.trxId }, defaultMutateOptions, options || {})
        );
      },
      reset() {
        this.operations = [];
        return this;
      },
      _add(mut) {
        this.operations.push(mut);
        return this;
      }
    });
    var transaction_default = Transaction;

    // src/data/encodeQueryString.js
    var enc$1 = encodeURIComponent;
    var encodeQueryString_default = ({ query, params = {}, options = {} }) => {
      const { tag, ...opts } = options;
      const q = `query=${enc$1(query)}`;
      const base = tag ? `?tag=${enc$1(tag)}&${q}` : `?${q}`;
      const qString = Object.keys(params).reduce(
        (qs, param) => `${qs}&${enc$1(`$${param}`)}=${enc$1(JSON.stringify(params[param]))}`,
        base
      );
      return Object.keys(opts).reduce((qs, option) => {
        return options[option] ? `${qs}&${enc$1(option)}=${enc$1(options[option])}` : qs;
      }, qString);
    };

    // src/data/listen.js
    var import_eventsource = __toESM(require_browser());

    // src/util/pick.js
    var pick_default = (obj, props) => props.reduce((selection, prop) => {
      if (typeof obj[prop] === "undefined") {
        return selection;
      }
      selection[prop] = obj[prop];
      return selection;
    }, {});

    // src/util/defaults.js
    var defaults_default = (obj, defaults) => Object.keys(defaults).concat(Object.keys(obj)).reduce((target, prop) => {
      target[prop] = typeof obj[prop] === "undefined" ? defaults[prop] : obj[prop];
      return target;
    }, {});

    // node_modules/tslib/tslib.es6.js
    var extendStatics = function(d, b) {
      extendStatics = Object.setPrototypeOf || { __proto__: [] } instanceof Array && function(d2, b2) {
        d2.__proto__ = b2;
      } || function(d2, b2) {
        for (var p in b2)
          if (Object.prototype.hasOwnProperty.call(b2, p))
            d2[p] = b2[p];
      };
      return extendStatics(d, b);
    };
    function __extends(d, b) {
      if (typeof b !== "function" && b !== null)
        throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");
      extendStatics(d, b);
      function __() {
        this.constructor = d;
      }
      d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    }
    function __values(o) {
      var s = typeof Symbol === "function" && Symbol.iterator, m = s && o[s], i = 0;
      if (m)
        return m.call(o);
      if (o && typeof o.length === "number")
        return {
          next: function() {
            if (o && i >= o.length)
              o = void 0;
            return { value: o && o[i++], done: !o };
          }
        };
      throw new TypeError(s ? "Object is not iterable." : "Symbol.iterator is not defined.");
    }
    function __read(o, n) {
      var m = typeof Symbol === "function" && o[Symbol.iterator];
      if (!m)
        return o;
      var i = m.call(o), r, ar = [], e;
      try {
        while ((n === void 0 || n-- > 0) && !(r = i.next()).done)
          ar.push(r.value);
      } catch (error) {
        e = { error };
      } finally {
        try {
          if (r && !r.done && (m = i["return"]))
            m.call(i);
        } finally {
          if (e)
            throw e.error;
        }
      }
      return ar;
    }
    function __spreadArray(to, from, pack) {
      if (pack || arguments.length === 2)
        for (var i = 0, l = from.length, ar; i < l; i++) {
          if (ar || !(i in from)) {
            if (!ar)
              ar = Array.prototype.slice.call(from, 0, i);
            ar[i] = from[i];
          }
        }
      return to.concat(ar || Array.prototype.slice.call(from));
    }

    // node_modules/rxjs/dist/esm5/internal/util/isFunction.js
    function isFunction(value) {
      return typeof value === "function";
    }

    // node_modules/rxjs/dist/esm5/internal/util/createErrorClass.js
    function createErrorClass(createImpl) {
      var _super = function(instance) {
        Error.call(instance);
        instance.stack = new Error().stack;
      };
      var ctorFunc = createImpl(_super);
      ctorFunc.prototype = Object.create(Error.prototype);
      ctorFunc.prototype.constructor = ctorFunc;
      return ctorFunc;
    }

    // node_modules/rxjs/dist/esm5/internal/util/UnsubscriptionError.js
    var UnsubscriptionError = createErrorClass(function(_super) {
      return function UnsubscriptionErrorImpl(errors) {
        _super(this);
        this.message = errors ? errors.length + " errors occurred during unsubscription:\n" + errors.map(function(err, i) {
          return i + 1 + ") " + err.toString();
        }).join("\n  ") : "";
        this.name = "UnsubscriptionError";
        this.errors = errors;
      };
    });

    // node_modules/rxjs/dist/esm5/internal/util/arrRemove.js
    function arrRemove(arr, item) {
      if (arr) {
        var index = arr.indexOf(item);
        0 <= index && arr.splice(index, 1);
      }
    }

    // node_modules/rxjs/dist/esm5/internal/Subscription.js
    var Subscription = function() {
      function Subscription2(initialTeardown) {
        this.initialTeardown = initialTeardown;
        this.closed = false;
        this._parentage = null;
        this._finalizers = null;
      }
      Subscription2.prototype.unsubscribe = function() {
        var e_1, _a, e_2, _b;
        var errors;
        if (!this.closed) {
          this.closed = true;
          var _parentage = this._parentage;
          if (_parentage) {
            this._parentage = null;
            if (Array.isArray(_parentage)) {
              try {
                for (var _parentage_1 = __values(_parentage), _parentage_1_1 = _parentage_1.next(); !_parentage_1_1.done; _parentage_1_1 = _parentage_1.next()) {
                  var parent_1 = _parentage_1_1.value;
                  parent_1.remove(this);
                }
              } catch (e_1_1) {
                e_1 = { error: e_1_1 };
              } finally {
                try {
                  if (_parentage_1_1 && !_parentage_1_1.done && (_a = _parentage_1.return))
                    _a.call(_parentage_1);
                } finally {
                  if (e_1)
                    throw e_1.error;
                }
              }
            } else {
              _parentage.remove(this);
            }
          }
          var initialFinalizer = this.initialTeardown;
          if (isFunction(initialFinalizer)) {
            try {
              initialFinalizer();
            } catch (e) {
              errors = e instanceof UnsubscriptionError ? e.errors : [e];
            }
          }
          var _finalizers = this._finalizers;
          if (_finalizers) {
            this._finalizers = null;
            try {
              for (var _finalizers_1 = __values(_finalizers), _finalizers_1_1 = _finalizers_1.next(); !_finalizers_1_1.done; _finalizers_1_1 = _finalizers_1.next()) {
                var finalizer = _finalizers_1_1.value;
                try {
                  execFinalizer(finalizer);
                } catch (err) {
                  errors = errors !== null && errors !== void 0 ? errors : [];
                  if (err instanceof UnsubscriptionError) {
                    errors = __spreadArray(__spreadArray([], __read(errors)), __read(err.errors));
                  } else {
                    errors.push(err);
                  }
                }
              }
            } catch (e_2_1) {
              e_2 = { error: e_2_1 };
            } finally {
              try {
                if (_finalizers_1_1 && !_finalizers_1_1.done && (_b = _finalizers_1.return))
                  _b.call(_finalizers_1);
              } finally {
                if (e_2)
                  throw e_2.error;
              }
            }
          }
          if (errors) {
            throw new UnsubscriptionError(errors);
          }
        }
      };
      Subscription2.prototype.add = function(teardown) {
        var _a;
        if (teardown && teardown !== this) {
          if (this.closed) {
            execFinalizer(teardown);
          } else {
            if (teardown instanceof Subscription2) {
              if (teardown.closed || teardown._hasParent(this)) {
                return;
              }
              teardown._addParent(this);
            }
            (this._finalizers = (_a = this._finalizers) !== null && _a !== void 0 ? _a : []).push(teardown);
          }
        }
      };
      Subscription2.prototype._hasParent = function(parent) {
        var _parentage = this._parentage;
        return _parentage === parent || Array.isArray(_parentage) && _parentage.includes(parent);
      };
      Subscription2.prototype._addParent = function(parent) {
        var _parentage = this._parentage;
        this._parentage = Array.isArray(_parentage) ? (_parentage.push(parent), _parentage) : _parentage ? [_parentage, parent] : parent;
      };
      Subscription2.prototype._removeParent = function(parent) {
        var _parentage = this._parentage;
        if (_parentage === parent) {
          this._parentage = null;
        } else if (Array.isArray(_parentage)) {
          arrRemove(_parentage, parent);
        }
      };
      Subscription2.prototype.remove = function(teardown) {
        var _finalizers = this._finalizers;
        _finalizers && arrRemove(_finalizers, teardown);
        if (teardown instanceof Subscription2) {
          teardown._removeParent(this);
        }
      };
      Subscription2.EMPTY = function() {
        var empty = new Subscription2();
        empty.closed = true;
        return empty;
      }();
      return Subscription2;
    }();
    Subscription.EMPTY;
    function isSubscription(value) {
      return value instanceof Subscription || value && "closed" in value && isFunction(value.remove) && isFunction(value.add) && isFunction(value.unsubscribe);
    }
    function execFinalizer(finalizer) {
      if (isFunction(finalizer)) {
        finalizer();
      } else {
        finalizer.unsubscribe();
      }
    }

    // node_modules/rxjs/dist/esm5/internal/config.js
    var config = {
      onUnhandledError: null,
      onStoppedNotification: null,
      Promise: void 0,
      useDeprecatedSynchronousErrorHandling: false,
      useDeprecatedNextContext: false
    };

    // node_modules/rxjs/dist/esm5/internal/scheduler/timeoutProvider.js
    var timeoutProvider = {
      setTimeout: function(handler, timeout) {
        var args = [];
        for (var _i = 2; _i < arguments.length; _i++) {
          args[_i - 2] = arguments[_i];
        }
        return setTimeout.apply(void 0, __spreadArray([handler, timeout], __read(args)));
      },
      clearTimeout: function(handle) {
        return (clearTimeout)(handle);
      },
      delegate: void 0
    };

    // node_modules/rxjs/dist/esm5/internal/util/reportUnhandledError.js
    function reportUnhandledError(err) {
      timeoutProvider.setTimeout(function() {
        {
          throw err;
        }
      });
    }

    // node_modules/rxjs/dist/esm5/internal/util/noop.js
    function noop() {
    }
    function errorContext(cb) {
      {
        cb();
      }
    }

    // node_modules/rxjs/dist/esm5/internal/Subscriber.js
    var Subscriber = function(_super) {
      __extends(Subscriber2, _super);
      function Subscriber2(destination) {
        var _this = _super.call(this) || this;
        _this.isStopped = false;
        if (destination) {
          _this.destination = destination;
          if (isSubscription(destination)) {
            destination.add(_this);
          }
        } else {
          _this.destination = EMPTY_OBSERVER;
        }
        return _this;
      }
      Subscriber2.create = function(next, error, complete) {
        return new SafeSubscriber(next, error, complete);
      };
      Subscriber2.prototype.next = function(value) {
        if (this.isStopped) ; else {
          this._next(value);
        }
      };
      Subscriber2.prototype.error = function(err) {
        if (this.isStopped) ; else {
          this.isStopped = true;
          this._error(err);
        }
      };
      Subscriber2.prototype.complete = function() {
        if (this.isStopped) ; else {
          this.isStopped = true;
          this._complete();
        }
      };
      Subscriber2.prototype.unsubscribe = function() {
        if (!this.closed) {
          this.isStopped = true;
          _super.prototype.unsubscribe.call(this);
          this.destination = null;
        }
      };
      Subscriber2.prototype._next = function(value) {
        this.destination.next(value);
      };
      Subscriber2.prototype._error = function(err) {
        try {
          this.destination.error(err);
        } finally {
          this.unsubscribe();
        }
      };
      Subscriber2.prototype._complete = function() {
        try {
          this.destination.complete();
        } finally {
          this.unsubscribe();
        }
      };
      return Subscriber2;
    }(Subscription);
    var _bind = Function.prototype.bind;
    function bind(fn, thisArg) {
      return _bind.call(fn, thisArg);
    }
    var ConsumerObserver = function() {
      function ConsumerObserver2(partialObserver) {
        this.partialObserver = partialObserver;
      }
      ConsumerObserver2.prototype.next = function(value) {
        var partialObserver = this.partialObserver;
        if (partialObserver.next) {
          try {
            partialObserver.next(value);
          } catch (error) {
            handleUnhandledError(error);
          }
        }
      };
      ConsumerObserver2.prototype.error = function(err) {
        var partialObserver = this.partialObserver;
        if (partialObserver.error) {
          try {
            partialObserver.error(err);
          } catch (error) {
            handleUnhandledError(error);
          }
        } else {
          handleUnhandledError(err);
        }
      };
      ConsumerObserver2.prototype.complete = function() {
        var partialObserver = this.partialObserver;
        if (partialObserver.complete) {
          try {
            partialObserver.complete();
          } catch (error) {
            handleUnhandledError(error);
          }
        }
      };
      return ConsumerObserver2;
    }();
    var SafeSubscriber = function(_super) {
      __extends(SafeSubscriber2, _super);
      function SafeSubscriber2(observerOrNext, error, complete) {
        var _this = _super.call(this) || this;
        var partialObserver;
        if (isFunction(observerOrNext) || !observerOrNext) {
          partialObserver = {
            next: observerOrNext !== null && observerOrNext !== void 0 ? observerOrNext : void 0,
            error: error !== null && error !== void 0 ? error : void 0,
            complete: complete !== null && complete !== void 0 ? complete : void 0
          };
        } else {
          var context_1;
          if (_this && config.useDeprecatedNextContext) {
            context_1 = Object.create(observerOrNext);
            context_1.unsubscribe = function() {
              return _this.unsubscribe();
            };
            partialObserver = {
              next: observerOrNext.next && bind(observerOrNext.next, context_1),
              error: observerOrNext.error && bind(observerOrNext.error, context_1),
              complete: observerOrNext.complete && bind(observerOrNext.complete, context_1)
            };
          } else {
            partialObserver = observerOrNext;
          }
        }
        _this.destination = new ConsumerObserver(partialObserver);
        return _this;
      }
      return SafeSubscriber2;
    }(Subscriber);
    function handleUnhandledError(error) {
      {
        reportUnhandledError(error);
      }
    }
    function defaultErrorHandler(err) {
      throw err;
    }
    var EMPTY_OBSERVER = {
      closed: true,
      next: noop,
      error: defaultErrorHandler,
      complete: noop
    };

    // node_modules/rxjs/dist/esm5/internal/symbol/observable.js
    var observable = function() {
      return typeof Symbol === "function" && Symbol.observable || "@@observable";
    }();

    // node_modules/rxjs/dist/esm5/internal/util/identity.js
    function identity(x) {
      return x;
    }

    // node_modules/rxjs/dist/esm5/internal/util/pipe.js
    function pipeFromArray(fns) {
      if (fns.length === 0) {
        return identity;
      }
      if (fns.length === 1) {
        return fns[0];
      }
      return function piped(input) {
        return fns.reduce(function(prev, fn) {
          return fn(prev);
        }, input);
      };
    }

    // node_modules/rxjs/dist/esm5/internal/Observable.js
    var Observable = function() {
      function Observable2(subscribe) {
        if (subscribe) {
          this._subscribe = subscribe;
        }
      }
      Observable2.prototype.lift = function(operator) {
        var observable3 = new Observable2();
        observable3.source = this;
        observable3.operator = operator;
        return observable3;
      };
      Observable2.prototype.subscribe = function(observerOrNext, error, complete) {
        var _this = this;
        var subscriber = isSubscriber(observerOrNext) ? observerOrNext : new SafeSubscriber(observerOrNext, error, complete);
        errorContext(function() {
          var _a = _this, operator = _a.operator, source = _a.source;
          subscriber.add(operator ? operator.call(subscriber, source) : source ? _this._subscribe(subscriber) : _this._trySubscribe(subscriber));
        });
        return subscriber;
      };
      Observable2.prototype._trySubscribe = function(sink) {
        try {
          return this._subscribe(sink);
        } catch (err) {
          sink.error(err);
        }
      };
      Observable2.prototype.forEach = function(next, promiseCtor) {
        var _this = this;
        promiseCtor = getPromiseCtor(promiseCtor);
        return new promiseCtor(function(resolve, reject) {
          var subscriber = new SafeSubscriber({
            next: function(value) {
              try {
                next(value);
              } catch (err) {
                reject(err);
                subscriber.unsubscribe();
              }
            },
            error: reject,
            complete: resolve
          });
          _this.subscribe(subscriber);
        });
      };
      Observable2.prototype._subscribe = function(subscriber) {
        var _a;
        return (_a = this.source) === null || _a === void 0 ? void 0 : _a.subscribe(subscriber);
      };
      Observable2.prototype[observable] = function() {
        return this;
      };
      Observable2.prototype.pipe = function() {
        var operations = [];
        for (var _i = 0; _i < arguments.length; _i++) {
          operations[_i] = arguments[_i];
        }
        return pipeFromArray(operations)(this);
      };
      Observable2.prototype.toPromise = function(promiseCtor) {
        var _this = this;
        promiseCtor = getPromiseCtor(promiseCtor);
        return new promiseCtor(function(resolve, reject) {
          var value;
          _this.subscribe(function(x) {
            return value = x;
          }, function(err) {
            return reject(err);
          }, function() {
            return resolve(value);
          });
        });
      };
      Observable2.create = function(subscribe) {
        return new Observable2(subscribe);
      };
      return Observable2;
    }();
    function getPromiseCtor(promiseCtor) {
      var _a;
      return (_a = promiseCtor !== null && promiseCtor !== void 0 ? promiseCtor : config.Promise) !== null && _a !== void 0 ? _a : Promise;
    }
    function isObserver(value) {
      return value && isFunction(value.next) && isFunction(value.error) && isFunction(value.complete);
    }
    function isSubscriber(value) {
      return value && value instanceof Subscriber || isObserver(value) && isSubscription(value);
    }

    // node_modules/rxjs/dist/esm5/internal/util/lift.js
    function hasLift(source) {
      return isFunction(source === null || source === void 0 ? void 0 : source.lift);
    }
    function operate(init) {
      return function(source) {
        if (hasLift(source)) {
          return source.lift(function(liftedSource) {
            try {
              return init(liftedSource, this);
            } catch (err) {
              this.error(err);
            }
          });
        }
        throw new TypeError("Unable to lift unknown Observable type");
      };
    }

    // node_modules/rxjs/dist/esm5/internal/operators/OperatorSubscriber.js
    function createOperatorSubscriber(destination, onNext, onComplete, onError, onFinalize) {
      return new OperatorSubscriber(destination, onNext, onComplete, onError, onFinalize);
    }
    var OperatorSubscriber = function(_super) {
      __extends(OperatorSubscriber2, _super);
      function OperatorSubscriber2(destination, onNext, onComplete, onError, onFinalize, shouldUnsubscribe) {
        var _this = _super.call(this, destination) || this;
        _this.onFinalize = onFinalize;
        _this.shouldUnsubscribe = shouldUnsubscribe;
        _this._next = onNext ? function(value) {
          try {
            onNext(value);
          } catch (err) {
            destination.error(err);
          }
        } : _super.prototype._next;
        _this._error = onError ? function(err) {
          try {
            onError(err);
          } catch (err2) {
            destination.error(err2);
          } finally {
            this.unsubscribe();
          }
        } : _super.prototype._error;
        _this._complete = onComplete ? function() {
          try {
            onComplete();
          } catch (err) {
            destination.error(err);
          } finally {
            this.unsubscribe();
          }
        } : _super.prototype._complete;
        return _this;
      }
      OperatorSubscriber2.prototype.unsubscribe = function() {
        var _a;
        if (!this.shouldUnsubscribe || this.shouldUnsubscribe()) {
          var closed_1 = this.closed;
          _super.prototype.unsubscribe.call(this);
          !closed_1 && ((_a = this.onFinalize) === null || _a === void 0 ? void 0 : _a.call(this));
        }
      };
      return OperatorSubscriber2;
    }(Subscriber);

    // node_modules/rxjs/dist/esm5/internal/util/EmptyError.js
    var EmptyError = createErrorClass(function(_super) {
      return function EmptyErrorImpl() {
        _super(this);
        this.name = "EmptyError";
        this.message = "no elements in sequence";
      };
    });

    // node_modules/rxjs/dist/esm5/internal/lastValueFrom.js
    function lastValueFrom(source, config2) {
      var hasConfig = typeof config2 === "object";
      return new Promise(function(resolve, reject) {
        var _hasValue = false;
        var _value;
        source.subscribe({
          next: function(value) {
            _value = value;
            _hasValue = true;
          },
          error: reject,
          complete: function() {
            if (_hasValue) {
              resolve(_value);
            } else if (hasConfig) {
              resolve(config2.defaultValue);
            } else {
              reject(new EmptyError());
            }
          }
        });
      });
    }

    // node_modules/rxjs/dist/esm5/internal/operators/map.js
    function map(project, thisArg) {
      return operate(function(source, subscriber) {
        var index = 0;
        source.subscribe(createOperatorSubscriber(subscriber, function(value) {
          subscriber.next(project.call(thisArg, value, index++));
        }));
      });
    }

    // node_modules/rxjs/dist/esm5/internal/operators/filter.js
    function filter$1(predicate, thisArg) {
      return operate(function(source, subscriber) {
        var index = 0;
        source.subscribe(createOperatorSubscriber(subscriber, function(value) {
          return predicate.call(thisArg, value, index++) && subscriber.next(value);
        }));
      });
    }

    // src/data/listen.js
    var MAX_URL_LENGTH = 16e3 - 1200;
    var EventSource = import_eventsource.default;
    var possibleOptions = [
      "includePreviousRevision",
      "includeResult",
      "visibility",
      "effectFormat",
      "tag"
    ];
    var defaultOptions = {
      includeResult: true
    };
    function listen(query, params, opts = {}) {
      const { url, token, withCredentials, requestTagPrefix } = this.clientConfig;
      const tag = opts.tag && requestTagPrefix ? [requestTagPrefix, opts.tag].join(".") : opts.tag;
      const options = { ...defaults_default(opts, defaultOptions), tag };
      const listenOpts = pick_default(options, possibleOptions);
      const qs = encodeQueryString_default({ query, params, options: listenOpts, tag });
      const uri = `${url}${this.getDataUrl("listen", qs)}`;
      if (uri.length > MAX_URL_LENGTH) {
        return new Observable((observer) => observer.error(new Error("Query too large for listener")));
      }
      const listenFor = options.events ? options.events : ["mutation"];
      const shouldEmitReconnect = listenFor.indexOf("reconnect") !== -1;
      const esOptions = {};
      if (token || withCredentials) {
        esOptions.withCredentials = true;
      }
      if (token) {
        esOptions.headers = {
          Authorization: `Bearer ${token}`
        };
      }
      return new Observable((observer) => {
        let es = getEventSource();
        let reconnectTimer;
        let stopped = false;
        function onError() {
          if (stopped) {
            return;
          }
          emitReconnect();
          if (stopped) {
            return;
          }
          if (es.readyState === EventSource.CLOSED) {
            unsubscribe();
            clearTimeout(reconnectTimer);
            reconnectTimer = setTimeout(open, 100);
          }
        }
        function onChannelError(err) {
          observer.error(cooerceError(err));
        }
        function onMessage(evt) {
          const event = parseEvent(evt);
          return event instanceof Error ? observer.error(event) : observer.next(event);
        }
        function onDisconnect(evt) {
          stopped = true;
          unsubscribe();
          observer.complete();
        }
        function unsubscribe() {
          es.removeEventListener("error", onError, false);
          es.removeEventListener("channelError", onChannelError, false);
          es.removeEventListener("disconnect", onDisconnect, false);
          listenFor.forEach((type) => es.removeEventListener(type, onMessage, false));
          es.close();
        }
        function emitReconnect() {
          if (shouldEmitReconnect) {
            observer.next({ type: "reconnect" });
          }
        }
        function getEventSource() {
          const evs = new EventSource(uri, esOptions);
          evs.addEventListener("error", onError, false);
          evs.addEventListener("channelError", onChannelError, false);
          evs.addEventListener("disconnect", onDisconnect, false);
          listenFor.forEach((type) => evs.addEventListener(type, onMessage, false));
          return evs;
        }
        function open() {
          es = getEventSource();
        }
        function stop() {
          stopped = true;
          unsubscribe();
        }
        return stop;
      });
    }
    function parseEvent(event) {
      try {
        const data = event.data && JSON.parse(event.data) || {};
        return Object.assign({ type: event.type }, data);
      } catch (err) {
        return err;
      }
    }
    function cooerceError(err) {
      if (err instanceof Error) {
        return err;
      }
      const evt = parseEvent(err);
      return evt instanceof Error ? evt : new Error(extractErrorMessage(evt));
    }
    function extractErrorMessage(err) {
      if (!err.error) {
        return err.message || "Unknown listener error";
      }
      if (err.error.description) {
        return err.error.description;
      }
      return typeof err.error === "string" ? err.error : JSON.stringify(err.error, null, 2);
    }

    // src/data/dataMethods.js
    var excludeFalsey = (param, defValue) => {
      const value = typeof param === "undefined" ? defValue : param;
      return param === false ? void 0 : value;
    };
    var getMutationQuery = (options = {}) => {
      return {
        dryRun: options.dryRun,
        returnIds: true,
        returnDocuments: excludeFalsey(options.returnDocuments, true),
        visibility: options.visibility || "sync",
        autoGenerateArrayKeys: options.autoGenerateArrayKeys,
        skipCrossDatasetReferenceValidation: options.skipCrossDatasetReferenceValidation
      };
    };
    var isResponse = (event) => event.type === "response";
    var getBody = (event) => event.body;
    var indexBy = (docs, attr) => docs.reduce((indexed, doc) => {
      indexed[attr(doc)] = doc;
      return indexed;
    }, /* @__PURE__ */ Object.create(null));
    var getQuerySizeLimit = 11264;
    var dataMethods_default = {
      listen,
      getDataUrl(operation, path) {
        const config2 = this.clientConfig;
        const catalog = hasDataset(config2);
        const baseUri = `/${operation}/${catalog}`;
        const uri = path ? `${baseUri}/${path}` : baseUri;
        return `/data${uri}`.replace(/\/($|\?)/, "$1");
      },
      fetch(query, params, options = {}) {
        const mapResponse = options.filterResponse === false ? (res) => res : (res) => res.result;
        const observable3 = this._dataRequest("query", { query, params }, options).pipe(map(mapResponse));
        return this.isPromiseAPI() ? lastValueFrom(observable3) : observable3;
      },
      getDocument(id, opts = {}) {
        const options = { uri: this.getDataUrl("doc", id), json: true, tag: opts.tag };
        const observable3 = this._requestObservable(options).pipe(
          filter$1(isResponse),
          map((event) => event.body.documents && event.body.documents[0])
        );
        return this.isPromiseAPI() ? lastValueFrom(observable3) : observable3;
      },
      getDocuments(ids, opts = {}) {
        const options = { uri: this.getDataUrl("doc", ids.join(",")), json: true, tag: opts.tag };
        const observable3 = this._requestObservable(options).pipe(
          filter$1(isResponse),
          map((event) => {
            const indexed = indexBy(event.body.documents || [], (doc) => doc._id);
            return ids.map((id) => indexed[id] || null);
          })
        );
        return this.isPromiseAPI() ? lastValueFrom(observable3) : observable3;
      },
      create(doc, options) {
        return this._create(doc, "create", options);
      },
      createIfNotExists(doc, options) {
        requireDocumentId("createIfNotExists", doc);
        return this._create(doc, "createIfNotExists", options);
      },
      createOrReplace(doc, options) {
        requireDocumentId("createOrReplace", doc);
        return this._create(doc, "createOrReplace", options);
      },
      patch(selector, operations) {
        return new patch_default(selector, operations, this);
      },
      delete(selection, options) {
        return this.dataRequest("mutate", { mutations: [{ delete: getSelection(selection) }] }, options);
      },
      mutate(mutations, options) {
        const mut = mutations instanceof patch_default || mutations instanceof transaction_default ? mutations.serialize() : mutations;
        const muts = Array.isArray(mut) ? mut : [mut];
        const transactionId = options && options.transactionId;
        return this.dataRequest("mutate", { mutations: muts, transactionId }, options);
      },
      transaction(operations) {
        return new transaction_default(operations, this);
      },
      dataRequest(endpoint, body, options = {}) {
        const request2 = this._dataRequest(endpoint, body, options);
        return this.isPromiseAPI() ? lastValueFrom(request2) : request2;
      },
      _dataRequest(endpoint, body, options = {}) {
        const isMutation = endpoint === "mutate";
        const isQuery = endpoint === "query";
        const strQuery = !isMutation && encodeQueryString_default(body);
        const useGet = !isMutation && strQuery.length < getQuerySizeLimit;
        const stringQuery = useGet ? strQuery : "";
        const returnFirst = options.returnFirst;
        const { timeout, token, tag, headers } = options;
        const uri = this.getDataUrl(endpoint, stringQuery);
        const reqOptions = {
          method: useGet ? "GET" : "POST",
          uri,
          json: true,
          body: useGet ? void 0 : body,
          query: isMutation && getMutationQuery(options),
          timeout,
          headers,
          token,
          tag,
          canUseCdn: isQuery
        };
        return this._requestObservable(reqOptions).pipe(
          filter$1(isResponse),
          map(getBody),
          map((res) => {
            if (!isMutation) {
              return res;
            }
            const results = res.results || [];
            if (options.returnDocuments) {
              return returnFirst ? results[0] && results[0].document : results.map((mut) => mut.document);
            }
            const key = returnFirst ? "documentId" : "documentIds";
            const ids = returnFirst ? results[0] && results[0].id : results.map((mut) => mut.id);
            return {
              transactionId: res.transactionId,
              results,
              [key]: ids
            };
          })
        );
      },
      _create(doc, op, options = {}) {
        const mutation = { [op]: doc };
        const opts = Object.assign({ returnFirst: true, returnDocuments: true }, options);
        return this.dataRequest("mutate", { mutations: [mutation] }, opts);
      }
    };

    // src/datasets/datasetsClient.js
    function DatasetsClient(client) {
      this.request = client.request.bind(client);
    }
    Object.assign(DatasetsClient.prototype, {
      create(name, options) {
        return this._modify("PUT", name, options);
      },
      edit(name, options) {
        return this._modify("PATCH", name, options);
      },
      delete(name) {
        return this._modify("DELETE", name);
      },
      list() {
        return this.request({ uri: "/datasets" });
      },
      _modify(method, name, body) {
        dataset(name);
        return this.request({ method, uri: `/datasets/${name}`, body });
      }
    });
    var datasetsClient_default = DatasetsClient;

    // src/projects/projectsClient.js
    function ProjectsClient(client) {
      this.client = client;
    }
    Object.assign(ProjectsClient.prototype, {
      list() {
        return this.client.request({ uri: "/projects" });
      },
      getById(id) {
        return this.client.request({ uri: `/projects/${id}` });
      }
    });
    var projectsClient_default = ProjectsClient;

    // src/http/queryString.js
    var queryString_default = (params) => {
      const qs = [];
      for (const key in params) {
        if (params.hasOwnProperty(key)) {
          qs.push(`${encodeURIComponent(key)}=${encodeURIComponent(params[key])}`);
        }
      }
      return qs.length > 0 ? `?${qs.join("&")}` : "";
    };

    // src/assets/assetsClient.js
    function AssetsClient(client) {
      this.client = client;
    }
    function optionsFromFile(opts, file) {
      if (typeof window === "undefined" || !(file instanceof window.File)) {
        return opts;
      }
      return Object.assign(
        {
          filename: opts.preserveFilename === false ? void 0 : file.name,
          contentType: file.type
        },
        opts
      );
    }
    Object.assign(AssetsClient.prototype, {
      upload(assetType, body, opts = {}) {
        validateAssetType(assetType);
        let meta = opts.extract || void 0;
        if (meta && !meta.length) {
          meta = ["none"];
        }
        const dataset2 = hasDataset(this.client.clientConfig);
        const assetEndpoint = assetType === "image" ? "images" : "files";
        const options = optionsFromFile(opts, body);
        const { tag, label, title, description, creditLine, filename, source } = options;
        const query = {
          label,
          title,
          description,
          filename,
          meta,
          creditLine
        };
        if (source) {
          query.sourceId = source.id;
          query.sourceName = source.name;
          query.sourceUrl = source.url;
        }
        const observable3 = this.client._requestObservable({
          tag,
          method: "POST",
          timeout: options.timeout || 0,
          uri: `/assets/${assetEndpoint}/${dataset2}`,
          headers: options.contentType ? { "Content-Type": options.contentType } : {},
          query,
          body
        });
        return this.client.isPromiseAPI() ? lastValueFrom(
          observable3.pipe(
            filter$1((event) => event.type === "response"),
            map((event) => event.body.document)
          )
        ) : observable3;
      },
      delete(type, id) {
        console.warn("client.assets.delete() is deprecated, please use client.delete(<document-id>)");
        let docId = id || "";
        if (!/^(image|file)-/.test(docId)) {
          docId = `${type}-${docId}`;
        } else if (type._id) {
          docId = type._id;
        }
        hasDataset(this.client.clientConfig);
        return this.client.delete(docId);
      },
      getImageUrl(ref, query) {
        const id = ref._ref || ref;
        if (typeof id !== "string") {
          throw new Error(
            "getImageUrl() needs either an object with a _ref, or a string with an asset document ID"
          );
        }
        if (!/^image-[A-Za-z0-9_]+-\d+x\d+-[a-z]{1,5}$/.test(id)) {
          throw new Error(
            `Unsupported asset ID "${id}". URL generation only works for auto-generated IDs.`
          );
        }
        const [, assetId, size, format] = id.split("-");
        hasDataset(this.client.clientConfig);
        const { projectId: projectId2, dataset: dataset2 } = this.client.clientConfig;
        const qs = query ? queryString_default(query) : "";
        return `https://cdn.sanity.io/images/${projectId2}/${dataset2}/${assetId}-${size}.${format}${qs}`;
      }
    });
    var assetsClient_default = AssetsClient;

    // src/users/usersClient.js
    function UsersClient(client) {
      this.client = client;
    }
    Object.assign(UsersClient.prototype, {
      getById(id) {
        return this.client.request({ uri: `/users/${id}` });
      }
    });
    var usersClient_default = UsersClient;

    // src/auth/authClient.js
    function AuthClient(client) {
      this.client = client;
    }
    Object.assign(AuthClient.prototype, {
      getLoginProviders() {
        return this.client.request({ uri: "/auth/providers" });
      },
      logout() {
        return this.client.request({ uri: "/auth/logout", method: "POST" });
      }
    });
    var authClient_default = AuthClient;

    // src/http/errors.js
    var import_make_error = __toESM(require_make_error());
    function ClientError(res) {
      const props = extractErrorProps(res);
      ClientError.super.call(this, props.message);
      Object.assign(this, props);
    }
    function ServerError(res) {
      const props = extractErrorProps(res);
      ServerError.super.call(this, props.message);
      Object.assign(this, props);
    }
    function extractErrorProps(res) {
      const body = res.body;
      const props = {
        response: res,
        statusCode: res.statusCode,
        responseBody: stringifyBody(body, res)
      };
      if (body.error && body.message) {
        props.message = `${body.error} - ${body.message}`;
        return props;
      }
      if (body.error && body.error.description) {
        props.message = body.error.description;
        props.details = body.error;
        return props;
      }
      props.message = body.error || body.message || httpErrorMessage(res);
      return props;
    }
    function httpErrorMessage(res) {
      const statusMessage = res.statusMessage ? ` ${res.statusMessage}` : "";
      return `${res.method}-request to ${res.url} resulted in HTTP ${res.statusCode}${statusMessage}`;
    }
    function stringifyBody(body, res) {
      const contentType = (res.headers["content-type"] || "").toLowerCase();
      const isJson = contentType.indexOf("application/json") !== -1;
      return isJson ? JSON.stringify(body, null, 2) : body;
    }
    (0, import_make_error.default)(ClientError);
    (0, import_make_error.default)(ServerError);

    // src/http/browserMiddleware.js
    var browserMiddleware_default = [];

    // src/http/request.js
    var httpError = {
      onResponse: (res) => {
        if (res.statusCode >= 500) {
          throw new ServerError(res);
        } else if (res.statusCode >= 400) {
          throw new ClientError(res);
        }
        return res;
      }
    };
    var printWarnings = {
      onResponse: (res) => {
        const warn = res.headers["x-sanity-warning"];
        const warnings = Array.isArray(warn) ? warn : [warn];
        warnings.filter(Boolean).forEach((msg) => console.warn(msg));
        return res;
      }
    };
    var envSpecific = browserMiddleware_default;
    var middleware = envSpecific.concat([
      printWarnings,
      jsonRequest_default(),
      jsonResponse_default(),
      browser_progress_default(),
      httpError,
      observable_default({ implementation: Observable })
    ]);
    var request = getIt(middleware);
    function httpRequest(options, requester = request) {
      return requester(Object.assign({ maxRedirects: 0 }, options));
    }
    httpRequest.defaultRequester = request;
    httpRequest.ClientError = ClientError;
    httpRequest.ServerError = ServerError;
    var request_default = httpRequest;

    // src/http/requestOptions.js
    var projectHeader = "X-Sanity-Project-ID";
    var requestOptions_default = (config2, overrides = {}) => {
      const headers = {};
      const token = overrides.token || config2.token;
      if (token) {
        headers.Authorization = `Bearer ${token}`;
      }
      if (!overrides.useGlobalApi && !config2.useProjectHostname && config2.projectId) {
        headers[projectHeader] = config2.projectId;
      }
      const withCredentials = Boolean(
        typeof overrides.withCredentials === "undefined" ? config2.token || config2.withCredentials : overrides.withCredentials
      );
      const timeout = typeof overrides.timeout === "undefined" ? config2.timeout : overrides.timeout;
      return Object.assign({}, overrides, {
        headers: Object.assign({}, headers, overrides.headers || {}),
        timeout: typeof timeout === "undefined" ? 5 * 60 * 1e3 : timeout,
        proxy: overrides.proxy || config2.proxy,
        json: true,
        withCredentials
      });
    };

    // src/generateHelpUrl.js
    var BASE_URL = "https://docs.sanity.io/help/";
    function generateHelpUrl$2(slug) {
      return BASE_URL + slug;
    }

    // src/util/once.js
    var once_default = (fn) => {
      let didCall = false;
      let returnValue;
      return (...args) => {
        if (didCall) {
          return returnValue;
        }
        returnValue = fn(...args);
        didCall = true;
        return returnValue;
      };
    };

    // src/warnings.js
    var createWarningPrinter = (message) => once_default((...args) => console.warn(message.join(" "), ...args));
    var printCdnWarning = createWarningPrinter([
      "You are not using the Sanity CDN. That means your data is always fresh, but the CDN is faster and",
      `cheaper. Think about it! For more info, see ${generateHelpUrl$2("js-client-cdn-configuration")}.`,
      "To hide this warning, please set the `useCdn` option to either `true` or `false` when creating",
      "the client."
    ]);
    var printBrowserTokenWarning = createWarningPrinter([
      "You have configured Sanity client to use a token in the browser. This may cause unintentional security issues.",
      `See ${generateHelpUrl$2(
    "js-client-browser-token"
  )} for more information and how to hide this warning.`
    ]);
    var printNoApiVersionSpecifiedWarning = createWarningPrinter([
      "Using the Sanity client without specifying an API version is deprecated.",
      `See ${generateHelpUrl$2("js-client-api-version")}`
    ]);

    // src/config.js
    var defaultCdnHost = "apicdn.sanity.io";
    var defaultConfig = {
      apiHost: "https://api.sanity.io",
      apiVersion: "1",
      useProjectHostname: true,
      isPromiseAPI: true
    };
    var LOCALHOSTS = ["localhost", "127.0.0.1", "0.0.0.0"];
    var isLocal = (host) => LOCALHOSTS.indexOf(host) !== -1;
    var validateApiVersion = function validateApiVersion2(apiVersion) {
      if (apiVersion === "1" || apiVersion === "X") {
        return;
      }
      const apiDate = new Date(apiVersion);
      const apiVersionValid = /^\d{4}-\d{2}-\d{2}$/.test(apiVersion) && apiDate instanceof Date && apiDate.getTime() > 0;
      if (!apiVersionValid) {
        throw new Error("Invalid API version string, expected `1` or date in format `YYYY-MM-DD`");
      }
    };
    var initConfig = (config2, prevConfig) => {
      const specifiedConfig = Object.assign({}, prevConfig, config2);
      if (!specifiedConfig.apiVersion) {
        printNoApiVersionSpecifiedWarning();
      }
      const newConfig = Object.assign({}, defaultConfig, specifiedConfig);
      const projectBased = newConfig.useProjectHostname;
      if (typeof Promise === "undefined") {
        const helpUrl = generateHelpUrl$2("js-client-promise-polyfill");
        throw new Error(`No native Promise-implementation found, polyfill needed - see ${helpUrl}`);
      }
      if (projectBased && !newConfig.projectId) {
        throw new Error("Configuration must contain `projectId`");
      }
      const isBrowser = typeof window !== "undefined" && window.location && window.location.hostname;
      const isLocalhost = isBrowser && isLocal(window.location.hostname);
      if (isBrowser && isLocalhost && newConfig.token && newConfig.ignoreBrowserTokenWarning !== true) {
        printBrowserTokenWarning();
      } else if (typeof newConfig.useCdn === "undefined") {
        printCdnWarning();
      }
      if (projectBased) {
        projectId(newConfig.projectId);
      }
      if (newConfig.dataset) {
        dataset(newConfig.dataset);
      }
      if ("requestTagPrefix" in newConfig) {
        newConfig.requestTagPrefix = newConfig.requestTagPrefix ? requestTag(newConfig.requestTagPrefix).replace(/\.+$/, "") : void 0;
      }
      newConfig.apiVersion = `${newConfig.apiVersion}`.replace(/^v/, "");
      newConfig.isDefaultApi = newConfig.apiHost === defaultConfig.apiHost;
      newConfig.useCdn = Boolean(newConfig.useCdn) && !newConfig.withCredentials;
      validateApiVersion(newConfig.apiVersion);
      const hostParts = newConfig.apiHost.split("://", 2);
      const protocol = hostParts[0];
      const host = hostParts[1];
      const cdnHost = newConfig.isDefaultApi ? defaultCdnHost : host;
      if (newConfig.useProjectHostname) {
        newConfig.url = `${protocol}://${newConfig.projectId}.${host}/v${newConfig.apiVersion}`;
        newConfig.cdnUrl = `${protocol}://${newConfig.projectId}.${cdnHost}/v${newConfig.apiVersion}`;
      } else {
        newConfig.url = `${newConfig.apiHost}/v${newConfig.apiVersion}`;
        newConfig.cdnUrl = newConfig.url;
      }
      return newConfig;
    };

    // src/sanityClient.js
    function SanityClient(config2 = defaultConfig) {
      if (!(this instanceof SanityClient)) {
        return new SanityClient(config2);
      }
      this.config(config2);
      this.assets = new assetsClient_default(this);
      this.datasets = new datasetsClient_default(this);
      this.projects = new projectsClient_default(this);
      this.users = new usersClient_default(this);
      this.auth = new authClient_default(this);
      if (this.clientConfig.isPromiseAPI) {
        const observableConfig = Object.assign({}, this.clientConfig, { isPromiseAPI: false });
        this.observable = new SanityClient(observableConfig);
      }
    }
    Object.assign(SanityClient.prototype, dataMethods_default);
    Object.assign(SanityClient.prototype, {
      clone() {
        return new SanityClient(this.config());
      },
      config(newConfig) {
        if (typeof newConfig === "undefined") {
          return Object.assign({}, this.clientConfig);
        }
        if (this.clientConfig && this.clientConfig.allowReconfigure === false) {
          throw new Error(
            "Existing client instance cannot be reconfigured - use `withConfig(newConfig)` to return a new client"
          );
        }
        if (this.observable) {
          const observableConfig = Object.assign({}, newConfig, { isPromiseAPI: false });
          this.observable.config(observableConfig);
        }
        this.clientConfig = initConfig(newConfig, this.clientConfig || {});
        return this;
      },
      withConfig(newConfig) {
        return new SanityClient({ ...this.config(), ...newConfig });
      },
      getUrl(uri, useCdn = false) {
        const base = useCdn ? this.clientConfig.cdnUrl : this.clientConfig.url;
        return `${base}/${uri.replace(/^\//, "")}`;
      },
      isPromiseAPI() {
        return this.clientConfig.isPromiseAPI;
      },
      _requestObservable(options) {
        const uri = options.url || options.uri;
        const canUseCdn = typeof options.canUseCdn === "undefined" ? ["GET", "HEAD"].indexOf(options.method || "GET") >= 0 && uri.indexOf("/data/") === 0 : options.canUseCdn;
        const useCdn = this.clientConfig.useCdn && canUseCdn;
        const tag = options.tag && this.clientConfig.requestTagPrefix ? [this.clientConfig.requestTagPrefix, options.tag].join(".") : options.tag || this.clientConfig.requestTagPrefix;
        if (tag) {
          options.query = { tag: requestTag(tag), ...options.query };
        }
        const reqOptions = requestOptions_default(
          this.clientConfig,
          Object.assign({}, options, {
            url: this.getUrl(uri, useCdn)
          })
        );
        return new Observable(
          (subscriber) => request_default(reqOptions, this.clientConfig.requester).subscribe(subscriber)
        );
      },
      request(options) {
        const observable3 = this._requestObservable(options).pipe(
          filter$1((event) => event.type === "response"),
          map((event) => event.body)
        );
        return this.isPromiseAPI() ? lastValueFrom(observable3) : observable3;
      }
    });
    SanityClient.Patch = patch_default;
    SanityClient.Transaction = transaction_default;
    SanityClient.ClientError = request_default.ClientError;
    SanityClient.ServerError = request_default.ServerError;
    SanityClient.requester = request_default.defaultRequester;
    var sanityClient_default = SanityClient;
    /*! Bundled license information:

    event-source-polyfill/src/eventsource.js:
      (** @license
       * eventsource.js
       * Available under MIT License (MIT)
       * https://github.com/Yaffle/EventSource/
       *)
    */

    var hyperscriptExports = {};
    var hyperscript$1 = {
      get exports(){ return hyperscriptExports; },
      set exports(v){ hyperscriptExports = v; },
    };

    /*!
     * Cross-Browser Split 1.1.1
     * Copyright 2007-2012 Steven Levithan <stevenlevithan.com>
     * Available under the MIT License
     * ECMAScript compliant, uniform cross-browser split method
     */

    /**
     * Splits a string into an array of strings using a regex or string separator. Matches of the
     * separator are not included in the result array. However, if `separator` is a regex that contains
     * capturing groups, backreferences are spliced into the result each time `separator` is matched.
     * Fixes browser bugs compared to the native `String.prototype.split` and can be used reliably
     * cross-browser.
     * @param {String} str String to split.
     * @param {RegExp|String} separator Regex or string to use for separating the string.
     * @param {Number} [limit] Maximum number of items to include in the result array.
     * @returns {Array} Array of substrings.
     * @example
     *
     * // Basic use
     * split('a b c d', ' ');
     * // -> ['a', 'b', 'c', 'd']
     *
     * // With limit
     * split('a b c d', ' ', 2);
     * // -> ['a', 'b']
     *
     * // Backreferences in result array
     * split('..word1 word2..', /([a-z]+)(\d+)/i);
     * // -> ['..', 'word', '1', ' ', 'word', '2', '..']
     */
    var browserSplit = (function split(undef) {

      var nativeSplit = String.prototype.split,
        compliantExecNpcg = /()??/.exec("")[1] === undef,
        // NPCG: nonparticipating capturing group
        self;

      self = function(str, separator, limit) {
        // If `separator` is not a regex, use `nativeSplit`
        if (Object.prototype.toString.call(separator) !== "[object RegExp]") {
          return nativeSplit.call(str, separator, limit);
        }
        var output = [],
          flags = (separator.ignoreCase ? "i" : "") + (separator.multiline ? "m" : "") + (separator.extended ? "x" : "") + // Proposed for ES6
          (separator.sticky ? "y" : ""),
          // Firefox 3+
          lastLastIndex = 0,
          // Make `global` and avoid `lastIndex` issues by working with a copy
          separator = new RegExp(separator.source, flags + "g"),
          separator2, match, lastIndex, lastLength;
        str += ""; // Type-convert
        if (!compliantExecNpcg) {
          // Doesn't need flags gy, but they don't hurt
          separator2 = new RegExp("^" + separator.source + "$(?!\\s)", flags);
        }
        /* Values for `limit`, per the spec:
         * If undefined: 4294967295 // Math.pow(2, 32) - 1
         * If 0, Infinity, or NaN: 0
         * If positive number: limit = Math.floor(limit); if (limit > 4294967295) limit -= 4294967296;
         * If negative number: 4294967296 - Math.floor(Math.abs(limit))
         * If other: Type-convert, then use the above rules
         */
        limit = limit === undef ? -1 >>> 0 : // Math.pow(2, 32) - 1
        limit >>> 0; // ToUint32(limit)
        while (match = separator.exec(str)) {
          // `separator.lastIndex` is not reliable cross-browser
          lastIndex = match.index + match[0].length;
          if (lastIndex > lastLastIndex) {
            output.push(str.slice(lastLastIndex, match.index));
            // Fix browsers whose `exec` methods don't consistently return `undefined` for
            // nonparticipating capturing groups
            if (!compliantExecNpcg && match.length > 1) {
              match[0].replace(separator2, function() {
                for (var i = 1; i < arguments.length - 2; i++) {
                  if (arguments[i] === undef) {
                    match[i] = undef;
                  }
                }
              });
            }
            if (match.length > 1 && match.index < str.length) {
              Array.prototype.push.apply(output, match.slice(1));
            }
            lastLength = match[0].length;
            lastLastIndex = lastIndex;
            if (output.length >= limit) {
              break;
            }
          }
          if (separator.lastIndex === match.index) {
            separator.lastIndex++; // Avoid an infinite loop
          }
        }
        if (lastLastIndex === str.length) {
          if (lastLength || !separator.test("")) {
            output.push("");
          }
        } else {
          output.push(str.slice(lastLastIndex));
        }
        return output.length > limit ? output.slice(0, limit) : output;
      };

      return self;
    })();

    var indexOf = [].indexOf;

    var indexof$1 = function(arr, obj){
      if (indexOf) return arr.indexOf(obj);
      for (var i = 0; i < arr.length; ++i) {
        if (arr[i] === obj) return i;
      }
      return -1;
    };

    // contains, add, remove, toggle
    var indexof = indexof$1;

    var classList = ClassList$1;

    function ClassList$1(elem) {
        var cl = elem.classList;

        if (cl) {
            return cl
        }

        var classList = {
            add: add
            , remove: remove
            , contains: contains
            , toggle: toggle
            , toString: $toString
            , length: 0
            , item: item
        };

        return classList

        function add(token) {
            var list = getTokens();
            if (indexof(list, token) > -1) {
                return
            }
            list.push(token);
            setTokens(list);
        }

        function remove(token) {
            var list = getTokens()
                , index = indexof(list, token);

            if (index === -1) {
                return
            }

            list.splice(index, 1);
            setTokens(list);
        }

        function contains(token) {
            return indexof(getTokens(), token) > -1
        }

        function toggle(token) {
            if (contains(token)) {
                remove(token);
                return false
            } else {
                add(token);
                return true
            }
        }

        function $toString() {
            return elem.className
        }

        function item(index) {
            var tokens = getTokens();
            return tokens[index] || null
        }

        function getTokens() {
            var className = elem.className;

            return filter(className.split(" "), isTruthy)
        }

        function setTokens(list) {
            var length = list.length;

            elem.className = list.join(" ");
            classList.length = length;

            for (var i = 0; i < list.length; i++) {
                classList[i] = list[i];
            }

            delete list[length];
        }
    }

    function filter (arr, fn) {
        var ret = [];
        for (var i = 0; i < arr.length; i++) {
            if (fn(arr[i])) ret.push(arr[i]);
        }
        return ret
    }

    function isTruthy(value) {
        return !!value
    }

    var _nodeResolve_empty = {};

    var _nodeResolve_empty$1 = /*#__PURE__*/Object.freeze({
        __proto__: null,
        default: _nodeResolve_empty
    });

    var require$$2 = /*@__PURE__*/getAugmentedNamespace(_nodeResolve_empty$1);

    var split = browserSplit;
    var ClassList = classList;

    var w = typeof window === 'undefined' ? require$$2 : window;
    var document$1 = w.document;
    var Text = w.Text;

    function context () {

      var cleanupFuncs = [];

      function h() {
        var args = [].slice.call(arguments), e = null;
        function item (l) {
          var r;
          function parseClass (string) {
            // Our minimal parser doesn’t understand escaping CSS special
            // characters like `#`. Don’t use them. More reading:
            // https://mathiasbynens.be/notes/css-escapes .

            var m = split(string, /([\.#]?[^\s#.]+)/);
            if(/^\.|#/.test(m[1]))
              e = document$1.createElement('div');
            forEach(m, function (v) {
              var s = v.substring(1,v.length);
              if(!v) return
              if(!e)
                e = document$1.createElement(v);
              else if (v[0] === '.')
                ClassList(e).add(s);
              else if (v[0] === '#')
                e.setAttribute('id', s);
            });
          }

          if(l == null)
            ;
          else if('string' === typeof l) {
            if(!e)
              parseClass(l);
            else
              e.appendChild(r = document$1.createTextNode(l));
          }
          else if('number' === typeof l
            || 'boolean' === typeof l
            || l instanceof Date
            || l instanceof RegExp ) {
              e.appendChild(r = document$1.createTextNode(l.toString()));
          }
          //there might be a better way to handle this...
          else if (isArray(l))
            forEach(l, item);
          else if(isNode(l))
            e.appendChild(r = l);
          else if(l instanceof Text)
            e.appendChild(r = l);
          else if ('object' === typeof l) {
            for (var k in l) {
              if('function' === typeof l[k]) {
                if(/^on\w+/.test(k)) {
                  (function (k, l) { // capture k, l in the closure
                    if (e.addEventListener){
                      e.addEventListener(k.substring(2), l[k], false);
                      cleanupFuncs.push(function(){
                        e.removeEventListener(k.substring(2), l[k], false);
                      });
                    }else {
                      e.attachEvent(k, l[k]);
                      cleanupFuncs.push(function(){
                        e.detachEvent(k, l[k]);
                      });
                    }
                  })(k, l);
                } else {
                  // observable
                  e[k] = l[k]();
                  cleanupFuncs.push(l[k](function (v) {
                    e[k] = v;
                  }));
                }
              }
              else if(k === 'style') {
                if('string' === typeof l[k]) {
                  e.style.cssText = l[k];
                }else {
                  for (var s in l[k]) (function(s, v) {
                    if('function' === typeof v) {
                      // observable
                      e.style.setProperty(s, v());
                      cleanupFuncs.push(v(function (val) {
                        e.style.setProperty(s, val);
                      }));
                    } else
                      var match = l[k][s].match(/(.*)\W+!important\W*$/);
                      if (match) {
                        e.style.setProperty(s, match[1], 'important');
                      } else {
                        e.style.setProperty(s, l[k][s]);
                      }
                  })(s, l[k][s]);
                }
              } else if(k === 'attrs') {
                for (var v in l[k]) {
                  e.setAttribute(v, l[k][v]);
                }
              }
              else if (k.substr(0, 5) === "data-") {
                e.setAttribute(k, l[k]);
              } else {
                e[k] = l[k];
              }
            }
          } else if ('function' === typeof l) {
            //assume it's an observable!
            var v = l();
            e.appendChild(r = isNode(v) ? v : document$1.createTextNode(v));

            cleanupFuncs.push(l(function (v) {
              if(isNode(v) && r.parentElement)
                r.parentElement.replaceChild(v, r), r = v;
              else
                r.textContent = v;
            }));
          }

          return r
        }
        while(args.length)
          item(args.shift());

        return e
      }

      h.cleanup = function () {
        for (var i = 0; i < cleanupFuncs.length; i++){
          cleanupFuncs[i]();
        }
        cleanupFuncs.length = 0;
      };

      return h
    }

    var h$2 = hyperscript$1.exports = context();
    h$2.context = context;

    function isNode (el) {
      return el && el.nodeName && el.nodeType
    }

    function forEach (arr, fn) {
      if (arr.forEach) return arr.forEach(fn)
      for (var i = 0; i < arr.length; i++) fn(arr[i], i);
    }

    function isArray (arr) {
      return Object.prototype.toString.call(arr) == '[object Array]'
    }

    /*
    object-assign
    (c) Sindre Sorhus
    @license MIT
    */
    /* eslint-disable no-unused-vars */
    var getOwnPropertySymbols = Object.getOwnPropertySymbols;
    var hasOwnProperty = Object.prototype.hasOwnProperty;
    var propIsEnumerable = Object.prototype.propertyIsEnumerable;

    function toObject(val) {
    	if (val === null || val === undefined) {
    		throw new TypeError('Object.assign cannot be called with null or undefined');
    	}

    	return Object(val);
    }

    function shouldUseNative() {
    	try {
    		if (!Object.assign) {
    			return false;
    		}

    		// Detect buggy property enumeration order in older V8 versions.

    		// https://bugs.chromium.org/p/v8/issues/detail?id=4118
    		var test1 = new String('abc');  // eslint-disable-line no-new-wrappers
    		test1[5] = 'de';
    		if (Object.getOwnPropertyNames(test1)[0] === '5') {
    			return false;
    		}

    		// https://bugs.chromium.org/p/v8/issues/detail?id=3056
    		var test2 = {};
    		for (var i = 0; i < 10; i++) {
    			test2['_' + String.fromCharCode(i)] = i;
    		}
    		var order2 = Object.getOwnPropertyNames(test2).map(function (n) {
    			return test2[n];
    		});
    		if (order2.join('') !== '0123456789') {
    			return false;
    		}

    		// https://bugs.chromium.org/p/v8/issues/detail?id=3056
    		var test3 = {};
    		'abcdefghijklmnopqrst'.split('').forEach(function (letter) {
    			test3[letter] = letter;
    		});
    		if (Object.keys(Object.assign({}, test3)).join('') !==
    				'abcdefghijklmnopqrst') {
    			return false;
    		}

    		return true;
    	} catch (err) {
    		// We don't expect any of the above to throw, but better to be safe.
    		return false;
    	}
    }

    var objectAssign$7 = shouldUseNative() ? Object.assign : function (target, source) {
    	var from;
    	var to = toObject(target);
    	var symbols;

    	for (var s = 1; s < arguments.length; s++) {
    		from = Object(arguments[s]);

    		for (var key in from) {
    			if (hasOwnProperty.call(from, key)) {
    				to[key] = from[key];
    			}
    		}

    		if (getOwnPropertySymbols) {
    			symbols = getOwnPropertySymbols(from);
    			for (var i = 0; i < symbols.length; i++) {
    				if (propIsEnumerable.call(from, symbols[i])) {
    					to[symbols[i]] = from[symbols[i]];
    				}
    			}
    		}
    	}

    	return to;
    };

    var baseUrl = 'https://docs.sanity.io/help/';

    var generateHelpUrl$1 = function generateHelpUrl(slug) {
      return baseUrl + slug
    };

    var imageUrl_umdExports$1 = {};
    var imageUrl_umd$1 = {
      get exports(){ return imageUrl_umdExports$1; },
      set exports(v){ imageUrl_umdExports$1 = v; },
    };

    (function (module, exports) {
    	(function (global, factory) {
    	  module.exports = factory() ;
    	}(commonjsGlobal, (function () {
    	  function _extends() {
    	    _extends = Object.assign || function (target) {
    	      for (var i = 1; i < arguments.length; i++) {
    	        var source = arguments[i];

    	        for (var key in source) {
    	          if (Object.prototype.hasOwnProperty.call(source, key)) {
    	            target[key] = source[key];
    	          }
    	        }
    	      }

    	      return target;
    	    };

    	    return _extends.apply(this, arguments);
    	  }

    	  function _unsupportedIterableToArray(o, minLen) {
    	    if (!o) return;
    	    if (typeof o === "string") return _arrayLikeToArray(o, minLen);
    	    var n = Object.prototype.toString.call(o).slice(8, -1);
    	    if (n === "Object" && o.constructor) n = o.constructor.name;
    	    if (n === "Map" || n === "Set") return Array.from(o);
    	    if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
    	  }

    	  function _arrayLikeToArray(arr, len) {
    	    if (len == null || len > arr.length) len = arr.length;

    	    for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i];

    	    return arr2;
    	  }

    	  function _createForOfIteratorHelperLoose(o) {
    	    var i = 0;

    	    if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) {
    	      if (Array.isArray(o) || (o = _unsupportedIterableToArray(o))) return function () {
    	        if (i >= o.length) return {
    	          done: true
    	        };
    	        return {
    	          done: false,
    	          value: o[i++]
    	        };
    	      };
    	      throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
    	    }

    	    i = o[Symbol.iterator]();
    	    return i.next.bind(i);
    	  }

    	  var example = 'image-Tb9Ew8CXIwaY6R1kjMvI0uRR-2000x3000-jpg';
    	  function parseAssetId(ref) {
    	    var _ref$split = ref.split('-'),
    	        id = _ref$split[1],
    	        dimensionString = _ref$split[2],
    	        format = _ref$split[3];

    	    if (!id || !dimensionString || !format) {
    	      throw new Error("Malformed asset _ref '" + ref + "'. Expected an id like \"" + example + "\".");
    	    }

    	    var _dimensionString$spli = dimensionString.split('x'),
    	        imgWidthStr = _dimensionString$spli[0],
    	        imgHeightStr = _dimensionString$spli[1];

    	    var width = +imgWidthStr;
    	    var height = +imgHeightStr;
    	    var isValidAssetId = isFinite(width) && isFinite(height);

    	    if (!isValidAssetId) {
    	      throw new Error("Malformed asset _ref '" + ref + "'. Expected an id like \"" + example + "\".");
    	    }

    	    return {
    	      id: id,
    	      width: width,
    	      height: height,
    	      format: format
    	    };
    	  }

    	  var isRef = function isRef(src) {
    	    var source = src;
    	    return source ? typeof source._ref === 'string' : false;
    	  };

    	  var isAsset = function isAsset(src) {
    	    var source = src;
    	    return source ? typeof source._id === 'string' : false;
    	  };

    	  var isAssetStub = function isAssetStub(src) {
    	    var source = src;
    	    return source && source.asset ? typeof source.asset.url === 'string' : false;
    	  };

    	  function parseSource(source) {
    	    if (!source) {
    	      return null;
    	    }

    	    var image;

    	    if (typeof source === 'string' && isUrl(source)) {
    	      image = {
    	        asset: {
    	          _ref: urlToId(source)
    	        }
    	      };
    	    } else if (typeof source === 'string') {
    	      image = {
    	        asset: {
    	          _ref: source
    	        }
    	      };
    	    } else if (isRef(source)) {
    	      image = {
    	        asset: source
    	      };
    	    } else if (isAsset(source)) {
    	      image = {
    	        asset: {
    	          _ref: source._id || ''
    	        }
    	      };
    	    } else if (isAssetStub(source)) {
    	      image = {
    	        asset: {
    	          _ref: urlToId(source.asset.url)
    	        }
    	      };
    	    } else if (typeof source.asset === 'object') {
    	      image = source;
    	    } else {
    	      return null;
    	    }

    	    var img = source;

    	    if (img.crop) {
    	      image.crop = img.crop;
    	    }

    	    if (img.hotspot) {
    	      image.hotspot = img.hotspot;
    	    }

    	    return applyDefaults(image);
    	  }

    	  function isUrl(url) {
    	    return /^https?:\/\//.test("" + url);
    	  }

    	  function urlToId(url) {
    	    var parts = url.split('/').slice(-1);
    	    return ("image-" + parts[0]).replace(/\.([a-z]+)$/, '-$1');
    	  }

    	  function applyDefaults(image) {
    	    if (image.crop && image.hotspot) {
    	      return image;
    	    }

    	    var result = _extends({}, image);

    	    if (!result.crop) {
    	      result.crop = {
    	        left: 0,
    	        top: 0,
    	        bottom: 0,
    	        right: 0
    	      };
    	    }

    	    if (!result.hotspot) {
    	      result.hotspot = {
    	        x: 0.5,
    	        y: 0.5,
    	        height: 1.0,
    	        width: 1.0
    	      };
    	    }

    	    return result;
    	  }

    	  var SPEC_NAME_TO_URL_NAME_MAPPINGS = [['width', 'w'], ['height', 'h'], ['format', 'fm'], ['download', 'dl'], ['blur', 'blur'], ['sharpen', 'sharp'], ['invert', 'invert'], ['orientation', 'or'], ['minHeight', 'min-h'], ['maxHeight', 'max-h'], ['minWidth', 'min-w'], ['maxWidth', 'max-w'], ['quality', 'q'], ['fit', 'fit'], ['crop', 'crop'], ['saturation', 'sat'], ['auto', 'auto'], ['dpr', 'dpr'], ['pad', 'pad']];
    	  function urlForImage(options) {
    	    var spec = _extends({}, options || {});

    	    var source = spec.source;
    	    delete spec.source;
    	    var image = parseSource(source);

    	    if (!image) {
    	      return null;
    	    }

    	    var id = image.asset._ref || image.asset._id || '';
    	    var asset = parseAssetId(id);
    	    var cropLeft = Math.round(image.crop.left * asset.width);
    	    var cropTop = Math.round(image.crop.top * asset.height);
    	    var crop = {
    	      left: cropLeft,
    	      top: cropTop,
    	      width: Math.round(asset.width - image.crop.right * asset.width - cropLeft),
    	      height: Math.round(asset.height - image.crop.bottom * asset.height - cropTop)
    	    };
    	    var hotSpotVerticalRadius = image.hotspot.height * asset.height / 2;
    	    var hotSpotHorizontalRadius = image.hotspot.width * asset.width / 2;
    	    var hotSpotCenterX = image.hotspot.x * asset.width;
    	    var hotSpotCenterY = image.hotspot.y * asset.height;
    	    var hotspot = {
    	      left: hotSpotCenterX - hotSpotHorizontalRadius,
    	      top: hotSpotCenterY - hotSpotVerticalRadius,
    	      right: hotSpotCenterX + hotSpotHorizontalRadius,
    	      bottom: hotSpotCenterY + hotSpotVerticalRadius
    	    };

    	    if (!(spec.rect || spec.focalPoint || spec.ignoreImageParams || spec.crop)) {
    	      spec = _extends(_extends({}, spec), fit({
    	        crop: crop,
    	        hotspot: hotspot
    	      }, spec));
    	    }

    	    return specToImageUrl(_extends(_extends({}, spec), {}, {
    	      asset: asset
    	    }));
    	  }

    	  function specToImageUrl(spec) {
    	    var cdnUrl = spec.baseUrl || 'https://cdn.sanity.io';
    	    var filename = spec.asset.id + "-" + spec.asset.width + "x" + spec.asset.height + "." + spec.asset.format;
    	    var baseUrl = cdnUrl + "/images/" + spec.projectId + "/" + spec.dataset + "/" + filename;
    	    var params = [];

    	    if (spec.rect) {
    	      var _spec$rect = spec.rect,
    	          left = _spec$rect.left,
    	          top = _spec$rect.top,
    	          width = _spec$rect.width,
    	          height = _spec$rect.height;
    	      var isEffectiveCrop = left !== 0 || top !== 0 || height !== spec.asset.height || width !== spec.asset.width;

    	      if (isEffectiveCrop) {
    	        params.push("rect=" + left + "," + top + "," + width + "," + height);
    	      }
    	    }

    	    if (spec.bg) {
    	      params.push("bg=" + spec.bg);
    	    }

    	    if (spec.focalPoint) {
    	      params.push("fp-x=" + spec.focalPoint.x);
    	      params.push("fp-y=" + spec.focalPoint.y);
    	    }

    	    var flip = [spec.flipHorizontal && 'h', spec.flipVertical && 'v'].filter(Boolean).join('');

    	    if (flip) {
    	      params.push("flip=" + flip);
    	    }

    	    SPEC_NAME_TO_URL_NAME_MAPPINGS.forEach(function (mapping) {
    	      var specName = mapping[0],
    	          param = mapping[1];

    	      if (typeof spec[specName] !== 'undefined') {
    	        params.push(param + "=" + encodeURIComponent(spec[specName]));
    	      } else if (typeof spec[param] !== 'undefined') {
    	        params.push(param + "=" + encodeURIComponent(spec[param]));
    	      }
    	    });

    	    if (params.length === 0) {
    	      return baseUrl;
    	    }

    	    return baseUrl + "?" + params.join('&');
    	  }

    	  function fit(source, spec) {
    	    var cropRect;
    	    var imgWidth = spec.width;
    	    var imgHeight = spec.height;

    	    if (!(imgWidth && imgHeight)) {
    	      return {
    	        width: imgWidth,
    	        height: imgHeight,
    	        rect: source.crop
    	      };
    	    }

    	    var crop = source.crop;
    	    var hotspot = source.hotspot;
    	    var desiredAspectRatio = imgWidth / imgHeight;
    	    var cropAspectRatio = crop.width / crop.height;

    	    if (cropAspectRatio > desiredAspectRatio) {
    	      var height = crop.height;
    	      var width = height * desiredAspectRatio;
    	      var top = crop.top;
    	      var hotspotXCenter = (hotspot.right - hotspot.left) / 2 + hotspot.left;
    	      var left = hotspotXCenter - width / 2;

    	      if (left < crop.left) {
    	        left = crop.left;
    	      } else if (left + width > crop.left + crop.width) {
    	        left = crop.left + crop.width - width;
    	      }

    	      cropRect = {
    	        left: Math.round(left),
    	        top: Math.round(top),
    	        width: Math.round(width),
    	        height: Math.round(height)
    	      };
    	    } else {
    	      var _width = crop.width;

    	      var _height = _width / desiredAspectRatio;

    	      var _left = crop.left;
    	      var hotspotYCenter = (hotspot.bottom - hotspot.top) / 2 + hotspot.top;

    	      var _top = hotspotYCenter - _height / 2;

    	      if (_top < crop.top) {
    	        _top = crop.top;
    	      } else if (_top + _height > crop.top + crop.height) {
    	        _top = crop.top + crop.height - _height;
    	      }

    	      cropRect = {
    	        left: Math.max(0, Math.floor(_left)),
    	        top: Math.max(0, Math.floor(_top)),
    	        width: Math.round(_width),
    	        height: Math.round(_height)
    	      };
    	    }

    	    return {
    	      width: imgWidth,
    	      height: imgHeight,
    	      rect: cropRect
    	    };
    	  }

    	  var validFits = ['clip', 'crop', 'fill', 'fillmax', 'max', 'scale', 'min'];
    	  var validCrops = ['top', 'bottom', 'left', 'right', 'center', 'focalpoint', 'entropy'];
    	  var validAutoModes = ['format'];

    	  function isSanityClientLike(client) {
    	    return client ? typeof client.clientConfig === 'object' : false;
    	  }

    	  function rewriteSpecName(key) {
    	    var specs = SPEC_NAME_TO_URL_NAME_MAPPINGS;

    	    for (var _iterator = _createForOfIteratorHelperLoose(specs), _step; !(_step = _iterator()).done;) {
    	      var entry = _step.value;
    	      var specName = entry[0],
    	          param = entry[1];

    	      if (key === specName || key === param) {
    	        return specName;
    	      }
    	    }

    	    return key;
    	  }

    	  function urlBuilder(options) {
    	    var client = options;

    	    if (isSanityClientLike(client)) {
    	      var _client$clientConfig = client.clientConfig,
    	          apiUrl = _client$clientConfig.apiHost,
    	          projectId = _client$clientConfig.projectId,
    	          dataset = _client$clientConfig.dataset;
    	      var apiHost = apiUrl || 'https://api.sanity.io';
    	      return new ImageUrlBuilder(null, {
    	        baseUrl: apiHost.replace(/^https:\/\/api\./, 'https://cdn.'),
    	        projectId: projectId,
    	        dataset: dataset
    	      });
    	    }

    	    return new ImageUrlBuilder(null, options);
    	  }
    	  var ImageUrlBuilder = /*#__PURE__*/function () {
    	    function ImageUrlBuilder(parent, options) {
    	      this.options = parent ? _extends(_extends({}, parent.options || {}), options || {}) : _extends({}, options || {});
    	    }

    	    var _proto = ImageUrlBuilder.prototype;

    	    _proto.withOptions = function withOptions(options) {
    	      var baseUrl = options.baseUrl || this.options.baseUrl;
    	      var newOptions = {
    	        baseUrl: baseUrl
    	      };

    	      for (var key in options) {
    	        if (options.hasOwnProperty(key)) {
    	          var specKey = rewriteSpecName(key);
    	          newOptions[specKey] = options[key];
    	        }
    	      }

    	      return new ImageUrlBuilder(this, _extends({
    	        baseUrl: baseUrl
    	      }, newOptions));
    	    };

    	    _proto.image = function image(source) {
    	      return this.withOptions({
    	        source: source
    	      });
    	    };

    	    _proto.dataset = function dataset(_dataset) {
    	      return this.withOptions({
    	        dataset: _dataset
    	      });
    	    };

    	    _proto.projectId = function projectId(_projectId) {
    	      return this.withOptions({
    	        projectId: _projectId
    	      });
    	    };

    	    _proto.bg = function bg(_bg) {
    	      return this.withOptions({
    	        bg: _bg
    	      });
    	    };

    	    _proto.dpr = function dpr(_dpr) {
    	      return this.withOptions({
    	        dpr: _dpr
    	      });
    	    };

    	    _proto.width = function width(_width) {
    	      return this.withOptions({
    	        width: _width
    	      });
    	    };

    	    _proto.height = function height(_height) {
    	      return this.withOptions({
    	        height: _height
    	      });
    	    };

    	    _proto.focalPoint = function focalPoint(x, y) {
    	      return this.withOptions({
    	        focalPoint: {
    	          x: x,
    	          y: y
    	        }
    	      });
    	    };

    	    _proto.maxWidth = function maxWidth(_maxWidth) {
    	      return this.withOptions({
    	        maxWidth: _maxWidth
    	      });
    	    };

    	    _proto.minWidth = function minWidth(_minWidth) {
    	      return this.withOptions({
    	        minWidth: _minWidth
    	      });
    	    };

    	    _proto.maxHeight = function maxHeight(_maxHeight) {
    	      return this.withOptions({
    	        maxHeight: _maxHeight
    	      });
    	    };

    	    _proto.minHeight = function minHeight(_minHeight) {
    	      return this.withOptions({
    	        minHeight: _minHeight
    	      });
    	    };

    	    _proto.size = function size(width, height) {
    	      return this.withOptions({
    	        width: width,
    	        height: height
    	      });
    	    };

    	    _proto.blur = function blur(_blur) {
    	      return this.withOptions({
    	        blur: _blur
    	      });
    	    };

    	    _proto.sharpen = function sharpen(_sharpen) {
    	      return this.withOptions({
    	        sharpen: _sharpen
    	      });
    	    };

    	    _proto.rect = function rect(left, top, width, height) {
    	      return this.withOptions({
    	        rect: {
    	          left: left,
    	          top: top,
    	          width: width,
    	          height: height
    	        }
    	      });
    	    };

    	    _proto.format = function format(_format) {
    	      return this.withOptions({
    	        format: _format
    	      });
    	    };

    	    _proto.invert = function invert(_invert) {
    	      return this.withOptions({
    	        invert: _invert
    	      });
    	    };

    	    _proto.orientation = function orientation(_orientation) {
    	      return this.withOptions({
    	        orientation: _orientation
    	      });
    	    };

    	    _proto.quality = function quality(_quality) {
    	      return this.withOptions({
    	        quality: _quality
    	      });
    	    };

    	    _proto.forceDownload = function forceDownload(download) {
    	      return this.withOptions({
    	        download: download
    	      });
    	    };

    	    _proto.flipHorizontal = function flipHorizontal() {
    	      return this.withOptions({
    	        flipHorizontal: true
    	      });
    	    };

    	    _proto.flipVertical = function flipVertical() {
    	      return this.withOptions({
    	        flipVertical: true
    	      });
    	    };

    	    _proto.ignoreImageParams = function ignoreImageParams() {
    	      return this.withOptions({
    	        ignoreImageParams: true
    	      });
    	    };

    	    _proto.fit = function fit(value) {
    	      if (validFits.indexOf(value) === -1) {
    	        throw new Error("Invalid fit mode \"" + value + "\"");
    	      }

    	      return this.withOptions({
    	        fit: value
    	      });
    	    };

    	    _proto.crop = function crop(value) {
    	      if (validCrops.indexOf(value) === -1) {
    	        throw new Error("Invalid crop mode \"" + value + "\"");
    	      }

    	      return this.withOptions({
    	        crop: value
    	      });
    	    };

    	    _proto.saturation = function saturation(_saturation) {
    	      return this.withOptions({
    	        saturation: _saturation
    	      });
    	    };

    	    _proto.auto = function auto(value) {
    	      if (validAutoModes.indexOf(value) === -1) {
    	        throw new Error("Invalid auto mode \"" + value + "\"");
    	      }

    	      return this.withOptions({
    	        auto: value
    	      });
    	    };

    	    _proto.pad = function pad(_pad) {
    	      return this.withOptions({
    	        pad: _pad
    	      });
    	    };

    	    _proto.url = function url() {
    	      return urlForImage(this.options);
    	    };

    	    _proto.toString = function toString() {
    	      return this.url();
    	    };

    	    return ImageUrlBuilder;
    	  }();

    	  return urlBuilder;

    	})));
    	
    } (imageUrl_umd$1));

    var generateHelpUrl = generateHelpUrl$1;

    var urlBuilder = imageUrl_umdExports$1;

    var objectAssign$6 = objectAssign$7;

    var enc = encodeURIComponent;
    var materializeError = "You must either:\n  - Pass `projectId` and `dataset` to the block renderer\n  - Materialize images to include the `url` field.\n\nFor more information, see ".concat(generateHelpUrl('block-content-image-materializing'));

    var getQueryString = function getQueryString(options) {
      var query = options.imageOptions;
      var keys = Object.keys(query);

      if (!keys.length) {
        return '';
      }

      var params = keys.map(function (key) {
        return "".concat(enc(key), "=").concat(enc(query[key]));
      });
      return "?".concat(params.join('&'));
    };

    var buildUrl = function buildUrl(props) {
      var node = props.node,
          options = props.options;
      var projectId = options.projectId,
          dataset = options.dataset;
      var asset = node.asset;

      if (!asset) {
        throw new Error('Image does not have required `asset` property');
      }

      if (asset.url) {
        return asset.url + getQueryString(options);
      }

      if (!projectId || !dataset) {
        throw new Error(materializeError);
      }

      var ref = asset._ref;

      if (!ref) {
        throw new Error('Invalid image reference in block, no `_ref` found on `asset`');
      }

      return urlBuilder(objectAssign$6({
        projectId: projectId,
        dataset: dataset
      }, options.imageOptions || {})).image(node).toString();
    };

    var getImageUrl$2 = buildUrl;

    var defaultMarks = ['strong', 'em', 'code', 'underline', 'strike-through'];

    var buildMarksTree$1 = function buildMarksTree(block) {
      var children = block.children,
          markDefs = block.markDefs;

      if (!children || !children.length) {
        return [];
      }

      var sortedMarks = children.map(sortMarksByOccurences);
      var rootNode = {
        _type: 'span',
        children: []
      };
      var nodeStack = [rootNode];
      children.forEach(function (span, i) {
        var marksNeeded = sortedMarks[i];

        if (!marksNeeded) {
          var lastNode = nodeStack[nodeStack.length - 1];
          lastNode.children.push(span);
          return;
        }

        var pos = 1; // Start at position one. Root is always plain and should never be removed. (?)

        if (nodeStack.length > 1) {
          for (pos; pos < nodeStack.length; pos++) {
            var mark = nodeStack[pos].markKey;
            var index = marksNeeded.indexOf(mark); // eslint-disable-next-line max-depth

            if (index === -1) {
              break;
            }

            marksNeeded.splice(index, 1);
          }
        } // Keep from beginning to first miss


        nodeStack = nodeStack.slice(0, pos); // Add needed nodes

        var currentNode = findLastParentNode(nodeStack);
        marksNeeded.forEach(function (mark) {
          var node = {
            _type: 'span',
            _key: span._key,
            children: [],
            mark: markDefs.find(function (def) {
              return def._key === mark;
            }) || mark,
            markKey: mark
          };
          currentNode.children.push(node);
          nodeStack.push(node);
          currentNode = node;
        }); // Split at newlines to make individual line chunks, but keep newline
        // characters as individual elements in the array. We use these characters
        // in the span serializer to trigger hard-break rendering

        if (isTextSpan(span)) {
          var lines = span.text.split('\n');

          for (var line = lines.length; line-- > 1;) {
            lines.splice(line, 0, '\n');
          }

          currentNode.children = currentNode.children.concat(lines);
        } else {
          currentNode.children = currentNode.children.concat(span);
        }
      });
      return rootNode.children;
    }; // We want to sort all the marks of all the spans in the following order:
    // 1. Marks that are shared amongst the most adjacent siblings
    // 2. Non-default marks (links, custom metadata)
    // 3. Built-in, plain marks (bold, emphasis, code etc)


    function sortMarksByOccurences(span, i, spans) {
      if (!span.marks || span.marks.length === 0) {
        return span.marks || [];
      }

      var markOccurences = span.marks.reduce(function (occurences, mark) {
        occurences[mark] = occurences[mark] ? occurences[mark] + 1 : 1;

        for (var siblingIndex = i + 1; siblingIndex < spans.length; siblingIndex++) {
          var sibling = spans[siblingIndex];

          if (sibling.marks && Array.isArray(sibling.marks) && sibling.marks.indexOf(mark) !== -1) {
            occurences[mark]++;
          } else {
            break;
          }
        }

        return occurences;
      }, {});
      var sortByOccurence = sortMarks.bind(null, markOccurences); // Slicing because sort() mutates the input

      return span.marks.slice().sort(sortByOccurence);
    }

    function sortMarks(occurences, markA, markB) {
      var aOccurences = occurences[markA] || 0;
      var bOccurences = occurences[markB] || 0;

      if (aOccurences !== bOccurences) {
        return bOccurences - aOccurences;
      }

      var aDefaultPos = defaultMarks.indexOf(markA);
      var bDefaultPos = defaultMarks.indexOf(markB); // Sort default marks last

      if (aDefaultPos !== bDefaultPos) {
        return aDefaultPos - bDefaultPos;
      } // Sort other marks simply by key


      if (markA < markB) {
        return -1;
      } else if (markA > markB) {
        return 1;
      }

      return 0;
    }

    function isTextSpan(node) {
      return node._type === 'span' && typeof node.text === 'string' && (Array.isArray(node.marks) || typeof node.marks === 'undefined');
    }

    function findLastParentNode(nodes) {
      for (var i = nodes.length - 1; i >= 0; i--) {
        var node = nodes[i];

        if (node._type === 'span' && node.children) {
          return node;
        }
      }

      return undefined;
    }

    var buildMarksTree_1 = buildMarksTree$1;

    var objectAssign$5 = objectAssign$7;
    /* eslint-disable max-depth, complexity */


    function nestLists$1(blocks) {
      var mode = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'html';
      var tree = [];
      var currentList;

      for (var i = 0; i < blocks.length; i++) {
        var block = blocks[i];

        if (!isListBlock(block)) {
          tree.push(block);
          currentList = null;
          continue;
        } // Start of a new list?


        if (!currentList) {
          currentList = listFromBlock(block);
          tree.push(currentList);
          continue;
        } // New list item within same list?


        if (blockMatchesList(block, currentList)) {
          currentList.children.push(block);
          continue;
        } // Different list props, are we going deeper?


        if (block.level > currentList.level) {
          var newList = listFromBlock(block);

          if (mode === 'html') {
            // Because HTML is kinda weird, nested lists needs to be nested within list items
            // So while you would think that we could populate the parent list with a new sub-list,
            // We actually have to target the last list element (child) of the parent.
            // However, at this point we need to be very careful - simply pushing to the list of children
            // will mutate the input, and we don't want to blindly clone the entire tree.
            // Clone the last child while adding our new list as the last child of it
            var lastListItem = lastChild(currentList);
            var newLastChild = objectAssign$5({}, lastListItem, {
              children: lastListItem.children.concat(newList)
            }); // Swap the last child

            currentList.children[currentList.children.length - 1] = newLastChild;
          } else {
            currentList.children.push(newList);
          } // Set the newly created, deeper list as the current


          currentList = newList;
          continue;
        } // Different list props, are we going back up the tree?


        if (block.level < currentList.level) {
          // Current list has ended, and we need to hook up with a parent of the same level and type
          var match = findListMatching(tree[tree.length - 1], block);

          if (match) {
            currentList = match;
            currentList.children.push(block);
            continue;
          } // Similar parent can't be found, assume new list


          currentList = listFromBlock(block);
          tree.push(currentList);
          continue;
        } // Different list props, different list style?


        if (block.listItem !== currentList.listItem) {
          var _match = findListMatching(tree[tree.length - 1], {
            level: block.level
          });

          if (_match && _match.listItem === block.listItem) {
            currentList = _match;
            currentList.children.push(block);
            continue;
          } else {
            currentList = listFromBlock(block);
            tree.push(currentList);
            continue;
          }
        } // eslint-disable-next-line no-console


        console.warn('Unknown state encountered for block', block);
        tree.push(block);
      }

      return tree;
    }

    function isListBlock(block) {
      return Boolean(block.listItem);
    }

    function blockMatchesList(block, list) {
      return block.level === list.level && block.listItem === list.listItem;
    }

    function listFromBlock(block) {
      return {
        _type: 'list',
        _key: "".concat(block._key, "-parent"),
        level: block.level,
        listItem: block.listItem,
        children: [block]
      };
    }

    function lastChild(block) {
      return block.children && block.children[block.children.length - 1];
    }

    function findListMatching(rootNode, matching) {
      var filterOnType = typeof matching.listItem === 'string';

      if (rootNode._type === 'list' && rootNode.level === matching.level && filterOnType && rootNode.listItem === matching.listItem) {
        return rootNode;
      }

      var node = lastChild(rootNode);

      if (!node) {
        return false;
      }

      return findListMatching(node, matching);
    }

    var nestLists_1 = nestLists$1;

    var objectAssign$4 = objectAssign$7;

    var generateKeys$1 = function (blocks) {
      return blocks.map(function (block) {
        if (block._key) {
          return block;
        }

        return objectAssign$4({
          _key: getStaticKey(block)
        }, block);
      });
    };

    function getStaticKey(item) {
      return checksum(JSON.stringify(item)).toString(36).replace(/[^A-Za-z0-9]/g, '');
    }
    /* eslint-disable no-bitwise */


    function checksum(str) {
      var hash = 0;
      var strlen = str.length;

      if (strlen === 0) {
        return hash;
      }

      for (var i = 0; i < strlen; i++) {
        hash = (hash << 5) - hash + str.charCodeAt(i);
        hash &= hash; // Convert to 32bit integer
      }

      return hash;
    }

    function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

    var objectAssign$3 = objectAssign$7;

    var isDefined$1 = function isDefined(val) {
      return typeof val !== 'undefined';
    }; // Recursively merge/replace default serializers with user-specified serializers


    var mergeSerializers$1 = function mergeSerializers(defaultSerializers, userSerializers) {
      return Object.keys(defaultSerializers).reduce(function (acc, key) {
        var type = _typeof(defaultSerializers[key]);

        if (type === 'function') {
          acc[key] = isDefined$1(userSerializers[key]) ? userSerializers[key] : defaultSerializers[key];
        } else if (type === 'object') {
          acc[key] = objectAssign$3({}, defaultSerializers[key], userSerializers[key]);
        } else {
          acc[key] = typeof userSerializers[key] === 'undefined' ? defaultSerializers[key] : userSerializers[key];
        }

        return acc;
      }, {});
    };

    var objectAssign$2 = objectAssign$7;

    var buildMarksTree = buildMarksTree_1;

    var nestLists = nestLists_1;

    var generateKeys = generateKeys$1;

    var mergeSerializers = mergeSerializers$1; // Properties to extract from props and pass to serializers as options


    var optionProps = ['projectId', 'dataset', 'imageOptions', 'ignoreUnknownTypes'];

    var isDefined = function isDefined(val) {
      return typeof val !== 'undefined';
    };

    var defaults = {
      imageOptions: {},
      ignoreUnknownTypes: true
    };

    function blocksToNodes$1(h, properties, defaultSerializers, serializeSpan) {
      var props = objectAssign$2({}, defaults, properties);
      var rawBlocks = Array.isArray(props.blocks) ? props.blocks : [props.blocks];
      var keyedBlocks = generateKeys(rawBlocks);
      var blocks = nestLists(keyedBlocks, props.listNestMode);
      var serializers = mergeSerializers(defaultSerializers, props.serializers || {});
      var options = optionProps.reduce(function (opts, key) {
        var value = props[key];

        if (isDefined(value)) {
          opts[key] = value;
        }

        return opts;
      }, {});

      function serializeNode(node, index, siblings, isInline) {
        if (isList(node)) {
          return serializeList(node);
        }

        if (isListItem(node)) {
          return serializeListItem(node, findListItemIndex(node, siblings));
        }

        if (isSpan(node)) {
          return serializeSpan(node, serializers, index, {
            serializeNode: serializeNode
          });
        }

        return serializeBlock(node, index, isInline);
      }

      function findListItemIndex(node, siblings) {
        var index = 0;

        for (var i = 0; i < siblings.length; i++) {
          if (siblings[i] === node) {
            return index;
          }

          if (!isListItem(siblings[i])) {
            continue;
          }

          index++;
        }

        return index;
      }

      function serializeBlock(block, index, isInline) {
        var tree = buildMarksTree(block);
        var children = tree.map(function (node, i, siblings) {
          return serializeNode(node, i, siblings, true);
        });
        var blockProps = {
          key: block._key || "block-".concat(index),
          node: block,
          isInline: isInline,
          serializers: serializers,
          options: options
        };
        return h(serializers.block, blockProps, children);
      }

      function serializeListItem(block, index) {
        var key = block._key;
        var tree = buildMarksTree(block);
        var children = tree.map(serializeNode);
        return h(serializers.listItem, {
          node: block,
          serializers: serializers,
          index: index,
          key: key,
          options: options
        }, children);
      }

      function serializeList(list) {
        var type = list.listItem;
        var level = list.level;
        var key = list._key;
        var children = list.children.map(serializeNode);
        return h(serializers.list, {
          key: key,
          level: level,
          type: type,
          options: options
        }, children);
      } // Default to false, so `undefined` will evaluate to the default here


      var renderContainerOnSingleChild = Boolean(props.renderContainerOnSingleChild);
      var nodes = blocks.map(serializeNode);

      if (renderContainerOnSingleChild || nodes.length > 1) {
        var containerProps = props.className ? {
          className: props.className
        } : {};
        return h(serializers.container, containerProps, nodes);
      }

      if (nodes[0]) {
        return nodes[0];
      }

      return typeof serializers.empty === 'function' ? h(serializers.empty) : serializers.empty;
    }

    function isList(block) {
      return block._type === 'list' && block.listItem;
    }

    function isListItem(block) {
      return block._type === 'block' && block.listItem;
    }

    function isSpan(block) {
      return typeof block === 'string' || block.marks || block._type === 'span';
    }

    var blocksToNodes_1 = blocksToNodes$1;

    var objectAssign$1 = objectAssign$7;

    var getImageUrl$1 = getImageUrl$2;

    var serializers$1 = function (h, serializerOpts) {
      var serializeOptions = serializerOpts || {
        useDashedStyles: false
      }; // Low-level block serializer

      function BlockSerializer(props) {
        var node = props.node,
            serializers = props.serializers,
            options = props.options,
            isInline = props.isInline,
            children = props.children;
        var blockType = node._type;
        var serializer = serializers.types[blockType];

        if (!serializer) {
          if (options.ignoreUnknownTypes) {
            // eslint-disable-next-line no-console
            console.warn("Unknown block type \"".concat(blockType, "\", please specify a serializer for it in the `serializers.types` prop"));
            return h(serializers.unknownType, {
              node: node,
              options: options,
              isInline: isInline
            }, children);
          }

          throw new Error("Unknown block type \"".concat(blockType, "\", please specify a serializer for it in the `serializers.types` prop"));
        }

        return h(serializer, {
          node: node,
          options: options,
          isInline: isInline
        }, children);
      } // Low-level span serializer


      function SpanSerializer(props) {
        var _props$node = props.node,
            mark = _props$node.mark,
            children = _props$node.children;
        var isPlain = typeof mark === 'string';
        var markType = isPlain ? mark : mark._type;
        var serializer = props.serializers.marks[markType];

        if (!serializer) {
          // eslint-disable-next-line no-console
          console.warn("Unknown mark type \"".concat(markType, "\", please specify a serializer for it in the `serializers.marks` prop"));
          return h(props.serializers.unknownMark, null, children);
        }

        return h(serializer, props.node, children);
      } // Low-level list serializer


      function ListSerializer(props) {
        var tag = props.type === 'bullet' ? 'ul' : 'ol';
        return h(tag, null, props.children);
      } // Low-level list item serializer


      function ListItemSerializer(props) {
        var children = !props.node.style || props.node.style === 'normal' ? // Don't wrap plain text in paragraphs inside of a list item
        props.children : // But wrap any other style in whatever the block serializer says to use
        h(props.serializers.types.block, props, props.children);
        return h('li', null, children);
      } // Unknown type default serializer


      function DefaultUnknownTypeSerializer(props) {
        return h('div', {
          style: {
            display: 'none'
          }
        }, "Unknown block type \"".concat(props.node._type, "\", please specify a serializer for it in the `serializers.types` prop"));
      } // Renderer of an actual block of type `block`. Confusing, we know.


      function BlockTypeSerializer(props) {
        var style = props.node.style || 'normal';

        if (/^h\d/.test(style)) {
          return h(style, null, props.children);
        }

        return style === 'blockquote' ? h('blockquote', null, props.children) : h('p', null, props.children);
      } // Serializers for things that can be directly attributed to a tag without any props
      // We use partial application to do this, passing the tag name as the first argument


      function RawMarkSerializer(tag, props) {
        return h(tag, null, props.children);
      }

      function UnderlineSerializer(props) {
        var style = serializeOptions.useDashedStyles ? {
          'text-decoration': 'underline'
        } : {
          textDecoration: 'underline'
        };
        return h('span', {
          style: style
        }, props.children);
      }

      function StrikeThroughSerializer(props) {
        return h('del', null, props.children);
      }

      function LinkSerializer(props) {
        return h('a', {
          href: props.mark.href
        }, props.children);
      }

      function ImageSerializer(props) {
        if (!props.node.asset) {
          return null;
        }

        var img = h('img', {
          src: getImageUrl$1(props)
        });
        return props.isInline ? img : h('figure', null, img);
      } // Serializer that recursively calls itself, producing a hyperscript tree of spans


      function serializeSpan(span, serializers, index, options) {
        if (span === '\n' && serializers.hardBreak) {
          return h(serializers.hardBreak, {
            key: "hb-".concat(index)
          });
        }

        if (typeof span === 'string') {
          return serializers.text ? h(serializers.text, {
            key: "text-".concat(index)
          }, span) : span;
        }

        var children;

        if (span.children) {
          children = {
            children: span.children.map(function (child, i) {
              return options.serializeNode(child, i, span.children, true);
            })
          };
        }

        var serializedNode = objectAssign$1({}, span, children);
        return h(serializers.span, {
          key: span._key || "span-".concat(index),
          node: serializedNode,
          serializers: serializers
        });
      }

      var HardBreakSerializer = function HardBreakSerializer() {
        return h('br');
      };

      var defaultMarkSerializers = {
        strong: RawMarkSerializer.bind(null, 'strong'),
        em: RawMarkSerializer.bind(null, 'em'),
        code: RawMarkSerializer.bind(null, 'code'),
        underline: UnderlineSerializer,
        'strike-through': StrikeThroughSerializer,
        link: LinkSerializer
      };
      var defaultSerializers = {
        // Common overrides
        types: {
          block: BlockTypeSerializer,
          image: ImageSerializer
        },
        marks: defaultMarkSerializers,
        // Less common overrides
        list: ListSerializer,
        listItem: ListItemSerializer,
        block: BlockSerializer,
        span: SpanSerializer,
        hardBreak: HardBreakSerializer,
        unknownType: DefaultUnknownTypeSerializer,
        unknownMark: 'span',
        // Container element
        container: 'div',
        // Allow overriding text renderer, but leave undefined to just use plain strings by default
        text: undefined,
        // Empty nodes (React uses null, hyperscript with empty strings)
        empty: ''
      };
      return {
        defaultSerializers: defaultSerializers,
        serializeSpan: serializeSpan
      };
    };

    var hyperscript = hyperscriptExports;

    var objectAssign = objectAssign$7;

    var getImageUrl = getImageUrl$2;

    var blocksToNodes = blocksToNodes_1;

    var getSerializers = serializers$1;

    var renderNode = function renderNode(serializer, properties, children) {
      var props = properties || {};

      if (typeof serializer === 'function') {
        return serializer(objectAssign({}, props, {
          children: children
        }));
      }

      var tag = serializer;
      var childNodes = props.children || children;
      return hyperscript(tag, props, childNodes);
    };

    var _getSerializers = getSerializers(renderNode, {
      useDashedStyles: true
    }),
        defaultSerializers = _getSerializers.defaultSerializers,
        serializeSpan = _getSerializers.serializeSpan;

    var blockContentToHyperscript = function blockContentToHyperscript(options) {
      return blocksToNodes(renderNode, options, defaultSerializers, serializeSpan);
    }; // Expose default serializers to the user


    blockContentToHyperscript.defaultSerializers = defaultSerializers; // Expose logic for building image URLs from an image reference/node

    blockContentToHyperscript.getImageUrl = getImageUrl; // Expose node renderer

    blockContentToHyperscript.renderNode = renderNode;
    var lib = blockContentToHyperscript;

    var blocksToHyperScript = lib;

    var h$1 = blocksToHyperScript.renderNode;

    var blocksToHtml = function blocksToHtml(options) {
      var rootNode = blocksToHyperScript(options);
      return rootNode.outerHTML || rootNode;
    };

    blocksToHtml.defaultSerializers = blocksToHyperScript.defaultSerializers;
    blocksToHtml.getImageUrl = blocksToHyperScript.getImageUrl;
    blocksToHtml.renderNode = h$1;
    blocksToHtml.h = h$1;
    var blocksToHtml_1 = blocksToHtml;

    var imageUrl_umdExports = {};
    var imageUrl_umd = {
      get exports(){ return imageUrl_umdExports; },
      set exports(v){ imageUrl_umdExports = v; },
    };

    (function (module, exports) {
    	(function (global, factory) {
    	  module.exports = factory() ;
    	})(commonjsGlobal, (function () {
    	  function _extends() {
    	    _extends = Object.assign || function (target) {
    	      for (var i = 1; i < arguments.length; i++) {
    	        var source = arguments[i];

    	        for (var key in source) {
    	          if (Object.prototype.hasOwnProperty.call(source, key)) {
    	            target[key] = source[key];
    	          }
    	        }
    	      }

    	      return target;
    	    };

    	    return _extends.apply(this, arguments);
    	  }

    	  function _unsupportedIterableToArray(o, minLen) {
    	    if (!o) return;
    	    if (typeof o === "string") return _arrayLikeToArray(o, minLen);
    	    var n = Object.prototype.toString.call(o).slice(8, -1);
    	    if (n === "Object" && o.constructor) n = o.constructor.name;
    	    if (n === "Map" || n === "Set") return Array.from(o);
    	    if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
    	  }

    	  function _arrayLikeToArray(arr, len) {
    	    if (len == null || len > arr.length) len = arr.length;

    	    for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i];

    	    return arr2;
    	  }

    	  function _createForOfIteratorHelperLoose(o, allowArrayLike) {
    	    var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"];
    	    if (it) return (it = it.call(o)).next.bind(it);

    	    if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") {
    	      if (it) o = it;
    	      var i = 0;
    	      return function () {
    	        if (i >= o.length) return {
    	          done: true
    	        };
    	        return {
    	          done: false,
    	          value: o[i++]
    	        };
    	      };
    	    }

    	    throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
    	  }

    	  var example = 'image-Tb9Ew8CXIwaY6R1kjMvI0uRR-2000x3000-jpg';
    	  function parseAssetId(ref) {
    	    var _ref$split = ref.split('-'),
    	        id = _ref$split[1],
    	        dimensionString = _ref$split[2],
    	        format = _ref$split[3];

    	    if (!id || !dimensionString || !format) {
    	      throw new Error("Malformed asset _ref '" + ref + "'. Expected an id like \"" + example + "\".");
    	    }

    	    var _dimensionString$spli = dimensionString.split('x'),
    	        imgWidthStr = _dimensionString$spli[0],
    	        imgHeightStr = _dimensionString$spli[1];

    	    var width = +imgWidthStr;
    	    var height = +imgHeightStr;
    	    var isValidAssetId = isFinite(width) && isFinite(height);

    	    if (!isValidAssetId) {
    	      throw new Error("Malformed asset _ref '" + ref + "'. Expected an id like \"" + example + "\".");
    	    }

    	    return {
    	      id: id,
    	      width: width,
    	      height: height,
    	      format: format
    	    };
    	  }

    	  var isRef = function isRef(src) {
    	    var source = src;
    	    return source ? typeof source._ref === 'string' : false;
    	  };

    	  var isAsset = function isAsset(src) {
    	    var source = src;
    	    return source ? typeof source._id === 'string' : false;
    	  };

    	  var isAssetStub = function isAssetStub(src) {
    	    var source = src;
    	    return source && source.asset ? typeof source.asset.url === 'string' : false;
    	  }; // Convert an asset-id, asset or image to an image record suitable for processing
    	  // eslint-disable-next-line complexity


    	  function parseSource(source) {
    	    if (!source) {
    	      return null;
    	    }

    	    var image;

    	    if (typeof source === 'string' && isUrl(source)) {
    	      // Someone passed an existing image url?
    	      image = {
    	        asset: {
    	          _ref: urlToId(source)
    	        }
    	      };
    	    } else if (typeof source === 'string') {
    	      // Just an asset id
    	      image = {
    	        asset: {
    	          _ref: source
    	        }
    	      };
    	    } else if (isRef(source)) {
    	      // We just got passed an asset directly
    	      image = {
    	        asset: source
    	      };
    	    } else if (isAsset(source)) {
    	      // If we were passed an image asset document
    	      image = {
    	        asset: {
    	          _ref: source._id || ''
    	        }
    	      };
    	    } else if (isAssetStub(source)) {
    	      // If we were passed a partial asset (`url`, but no `_id`)
    	      image = {
    	        asset: {
    	          _ref: urlToId(source.asset.url)
    	        }
    	      };
    	    } else if (typeof source.asset === 'object') {
    	      // Probably an actual image with materialized asset
    	      image = _extends({}, source);
    	    } else {
    	      // We got something that does not look like an image, or it is an image
    	      // that currently isn't sporting an asset.
    	      return null;
    	    }

    	    var img = source;

    	    if (img.crop) {
    	      image.crop = img.crop;
    	    }

    	    if (img.hotspot) {
    	      image.hotspot = img.hotspot;
    	    }

    	    return applyDefaults(image);
    	  }

    	  function isUrl(url) {
    	    return /^https?:\/\//.test("" + url);
    	  }

    	  function urlToId(url) {
    	    var parts = url.split('/').slice(-1);
    	    return ("image-" + parts[0]).replace(/\.([a-z]+)$/, '-$1');
    	  } // Mock crop and hotspot if image lacks it


    	  function applyDefaults(image) {
    	    if (image.crop && image.hotspot) {
    	      return image;
    	    } // We need to pad in default values for crop or hotspot


    	    var result = _extends({}, image);

    	    if (!result.crop) {
    	      result.crop = {
    	        left: 0,
    	        top: 0,
    	        bottom: 0,
    	        right: 0
    	      };
    	    }

    	    if (!result.hotspot) {
    	      result.hotspot = {
    	        x: 0.5,
    	        y: 0.5,
    	        height: 1.0,
    	        width: 1.0
    	      };
    	    }

    	    return result;
    	  }

    	  var SPEC_NAME_TO_URL_NAME_MAPPINGS = [['width', 'w'], ['height', 'h'], ['format', 'fm'], ['download', 'dl'], ['blur', 'blur'], ['sharpen', 'sharp'], ['invert', 'invert'], ['orientation', 'or'], ['minHeight', 'min-h'], ['maxHeight', 'max-h'], ['minWidth', 'min-w'], ['maxWidth', 'max-w'], ['quality', 'q'], ['fit', 'fit'], ['crop', 'crop'], ['saturation', 'sat'], ['auto', 'auto'], ['dpr', 'dpr'], ['pad', 'pad']];
    	  function urlForImage(options) {
    	    var spec = _extends({}, options || {});

    	    var source = spec.source;
    	    delete spec.source;
    	    var image = parseSource(source);

    	    if (!image) {
    	      throw new Error("Unable to resolve image URL from source (" + JSON.stringify(source) + ")");
    	    }

    	    var id = image.asset._ref || image.asset._id || '';
    	    var asset = parseAssetId(id); // Compute crop rect in terms of pixel coordinates in the raw source image

    	    var cropLeft = Math.round(image.crop.left * asset.width);
    	    var cropTop = Math.round(image.crop.top * asset.height);
    	    var crop = {
    	      left: cropLeft,
    	      top: cropTop,
    	      width: Math.round(asset.width - image.crop.right * asset.width - cropLeft),
    	      height: Math.round(asset.height - image.crop.bottom * asset.height - cropTop)
    	    }; // Compute hot spot rect in terms of pixel coordinates

    	    var hotSpotVerticalRadius = image.hotspot.height * asset.height / 2;
    	    var hotSpotHorizontalRadius = image.hotspot.width * asset.width / 2;
    	    var hotSpotCenterX = image.hotspot.x * asset.width;
    	    var hotSpotCenterY = image.hotspot.y * asset.height;
    	    var hotspot = {
    	      left: hotSpotCenterX - hotSpotHorizontalRadius,
    	      top: hotSpotCenterY - hotSpotVerticalRadius,
    	      right: hotSpotCenterX + hotSpotHorizontalRadius,
    	      bottom: hotSpotCenterY + hotSpotVerticalRadius
    	    }; // If irrelevant, or if we are requested to: don't perform crop/fit based on
    	    // the crop/hotspot.

    	    if (!(spec.rect || spec.focalPoint || spec.ignoreImageParams || spec.crop)) {
    	      spec = _extends({}, spec, fit({
    	        crop: crop,
    	        hotspot: hotspot
    	      }, spec));
    	    }

    	    return specToImageUrl(_extends({}, spec, {
    	      asset: asset
    	    }));
    	  } // eslint-disable-next-line complexity

    	  function specToImageUrl(spec) {
    	    var cdnUrl = (spec.baseUrl || 'https://cdn.sanity.io').replace(/\/+$/, '');
    	    var filename = spec.asset.id + "-" + spec.asset.width + "x" + spec.asset.height + "." + spec.asset.format;
    	    var baseUrl = cdnUrl + "/images/" + spec.projectId + "/" + spec.dataset + "/" + filename;
    	    var params = [];

    	    if (spec.rect) {
    	      // Only bother url with a crop if it actually crops anything
    	      var _spec$rect = spec.rect,
    	          left = _spec$rect.left,
    	          top = _spec$rect.top,
    	          width = _spec$rect.width,
    	          height = _spec$rect.height;
    	      var isEffectiveCrop = left !== 0 || top !== 0 || height !== spec.asset.height || width !== spec.asset.width;

    	      if (isEffectiveCrop) {
    	        params.push("rect=" + left + "," + top + "," + width + "," + height);
    	      }
    	    }

    	    if (spec.bg) {
    	      params.push("bg=" + spec.bg);
    	    }

    	    if (spec.focalPoint) {
    	      params.push("fp-x=" + spec.focalPoint.x);
    	      params.push("fp-y=" + spec.focalPoint.y);
    	    }

    	    var flip = [spec.flipHorizontal && 'h', spec.flipVertical && 'v'].filter(Boolean).join('');

    	    if (flip) {
    	      params.push("flip=" + flip);
    	    } // Map from spec name to url param name, and allow using the actual param name as an alternative


    	    SPEC_NAME_TO_URL_NAME_MAPPINGS.forEach(function (mapping) {
    	      var specName = mapping[0],
    	          param = mapping[1];

    	      if (typeof spec[specName] !== 'undefined') {
    	        params.push(param + "=" + encodeURIComponent(spec[specName]));
    	      } else if (typeof spec[param] !== 'undefined') {
    	        params.push(param + "=" + encodeURIComponent(spec[param]));
    	      }
    	    });

    	    if (params.length === 0) {
    	      return baseUrl;
    	    }

    	    return baseUrl + "?" + params.join('&');
    	  }

    	  function fit(source, spec) {
    	    var cropRect;
    	    var imgWidth = spec.width;
    	    var imgHeight = spec.height; // If we are not constraining the aspect ratio, we'll just use the whole crop

    	    if (!(imgWidth && imgHeight)) {
    	      return {
    	        width: imgWidth,
    	        height: imgHeight,
    	        rect: source.crop
    	      };
    	    }

    	    var crop = source.crop;
    	    var hotspot = source.hotspot; // If we are here, that means aspect ratio is locked and fitting will be a bit harder

    	    var desiredAspectRatio = imgWidth / imgHeight;
    	    var cropAspectRatio = crop.width / crop.height;

    	    if (cropAspectRatio > desiredAspectRatio) {
    	      // The crop is wider than the desired aspect ratio. That means we are cutting from the sides
    	      var height = Math.round(crop.height);
    	      var width = Math.round(height * desiredAspectRatio);
    	      var top = Math.max(0, Math.round(crop.top)); // Center output horizontally over hotspot

    	      var hotspotXCenter = Math.round((hotspot.right - hotspot.left) / 2 + hotspot.left);
    	      var left = Math.max(0, Math.round(hotspotXCenter - width / 2)); // Keep output within crop

    	      if (left < crop.left) {
    	        left = crop.left;
    	      } else if (left + width > crop.left + crop.width) {
    	        left = crop.left + crop.width - width;
    	      }

    	      cropRect = {
    	        left: left,
    	        top: top,
    	        width: width,
    	        height: height
    	      };
    	    } else {
    	      // The crop is taller than the desired ratio, we are cutting from top and bottom
    	      var _width = crop.width;

    	      var _height = Math.round(_width / desiredAspectRatio);

    	      var _left = Math.max(0, Math.round(crop.left)); // Center output vertically over hotspot


    	      var hotspotYCenter = Math.round((hotspot.bottom - hotspot.top) / 2 + hotspot.top);

    	      var _top = Math.max(0, Math.round(hotspotYCenter - _height / 2)); // Keep output rect within crop


    	      if (_top < crop.top) {
    	        _top = crop.top;
    	      } else if (_top + _height > crop.top + crop.height) {
    	        _top = crop.top + crop.height - _height;
    	      }

    	      cropRect = {
    	        left: _left,
    	        top: _top,
    	        width: _width,
    	        height: _height
    	      };
    	    }

    	    return {
    	      width: imgWidth,
    	      height: imgHeight,
    	      rect: cropRect
    	    };
    	  } // For backwards-compatibility

    	  var validFits = ['clip', 'crop', 'fill', 'fillmax', 'max', 'scale', 'min'];
    	  var validCrops = ['top', 'bottom', 'left', 'right', 'center', 'focalpoint', 'entropy'];
    	  var validAutoModes = ['format'];

    	  function isSanityModernClientLike(client) {
    	    return client && 'config' in client ? typeof client.config === 'function' : false;
    	  }

    	  function isSanityClientLike(client) {
    	    return client && 'clientConfig' in client ? typeof client.clientConfig === 'object' : false;
    	  }

    	  function rewriteSpecName(key) {
    	    var specs = SPEC_NAME_TO_URL_NAME_MAPPINGS;

    	    for (var _iterator = _createForOfIteratorHelperLoose(specs), _step; !(_step = _iterator()).done;) {
    	      var entry = _step.value;
    	      var specName = entry[0],
    	          param = entry[1];

    	      if (key === specName || key === param) {
    	        return specName;
    	      }
    	    }

    	    return key;
    	  }

    	  function urlBuilder(options) {
    	    // Did we get a modernish client?
    	    if (isSanityModernClientLike(options)) {
    	      // Inherit config from client
    	      var _options$config = options.config(),
    	          apiUrl = _options$config.apiHost,
    	          projectId = _options$config.projectId,
    	          dataset = _options$config.dataset;

    	      var apiHost = apiUrl || 'https://api.sanity.io';
    	      return new ImageUrlBuilder(null, {
    	        baseUrl: apiHost.replace(/^https:\/\/api\./, 'https://cdn.'),
    	        projectId: projectId,
    	        dataset: dataset
    	      });
    	    } // Did we get a SanityClient?


    	    var client = options;

    	    if (isSanityClientLike(client)) {
    	      // Inherit config from client
    	      var _client$clientConfig = client.clientConfig,
    	          _apiUrl = _client$clientConfig.apiHost,
    	          _projectId = _client$clientConfig.projectId,
    	          _dataset = _client$clientConfig.dataset;

    	      var _apiHost = _apiUrl || 'https://api.sanity.io';

    	      return new ImageUrlBuilder(null, {
    	        baseUrl: _apiHost.replace(/^https:\/\/api\./, 'https://cdn.'),
    	        projectId: _projectId,
    	        dataset: _dataset
    	      });
    	    } // Or just accept the options as given


    	    return new ImageUrlBuilder(null, options);
    	  }
    	  var ImageUrlBuilder = /*#__PURE__*/function () {
    	    function ImageUrlBuilder(parent, options) {
    	      this.options = void 0;
    	      this.options = parent ? _extends({}, parent.options || {}, options || {}) // Merge parent options
    	      : _extends({}, options || {}); // Copy options
    	    }

    	    var _proto = ImageUrlBuilder.prototype;

    	    _proto.withOptions = function withOptions(options) {
    	      var baseUrl = options.baseUrl || this.options.baseUrl;
    	      var newOptions = {
    	        baseUrl: baseUrl
    	      };

    	      for (var key in options) {
    	        if (options.hasOwnProperty(key)) {
    	          var specKey = rewriteSpecName(key);
    	          newOptions[specKey] = options[key];
    	        }
    	      }

    	      return new ImageUrlBuilder(this, _extends({
    	        baseUrl: baseUrl
    	      }, newOptions));
    	    } // The image to be represented. Accepts a Sanity 'image'-document, 'asset'-document or
    	    // _id of asset. To get the benefit of automatic hot-spot/crop integration with the content
    	    // studio, the 'image'-document must be provided.
    	    ;

    	    _proto.image = function image(source) {
    	      return this.withOptions({
    	        source: source
    	      });
    	    } // Specify the dataset
    	    ;

    	    _proto.dataset = function dataset(_dataset2) {
    	      return this.withOptions({
    	        dataset: _dataset2
    	      });
    	    } // Specify the projectId
    	    ;

    	    _proto.projectId = function projectId(_projectId2) {
    	      return this.withOptions({
    	        projectId: _projectId2
    	      });
    	    } // Specify background color
    	    ;

    	    _proto.bg = function bg(_bg) {
    	      return this.withOptions({
    	        bg: _bg
    	      });
    	    } // Set DPR scaling factor
    	    ;

    	    _proto.dpr = function dpr(_dpr) {
    	      // A DPR of 1 is the default - so only include it if we have a different value
    	      return this.withOptions(_dpr && _dpr !== 1 ? {
    	        dpr: _dpr
    	      } : {});
    	    } // Specify the width of the image in pixels
    	    ;

    	    _proto.width = function width(_width) {
    	      return this.withOptions({
    	        width: _width
    	      });
    	    } // Specify the height of the image in pixels
    	    ;

    	    _proto.height = function height(_height) {
    	      return this.withOptions({
    	        height: _height
    	      });
    	    } // Specify focal point in fraction of image dimensions. Each component 0.0-1.0
    	    ;

    	    _proto.focalPoint = function focalPoint(x, y) {
    	      return this.withOptions({
    	        focalPoint: {
    	          x: x,
    	          y: y
    	        }
    	      });
    	    };

    	    _proto.maxWidth = function maxWidth(_maxWidth) {
    	      return this.withOptions({
    	        maxWidth: _maxWidth
    	      });
    	    };

    	    _proto.minWidth = function minWidth(_minWidth) {
    	      return this.withOptions({
    	        minWidth: _minWidth
    	      });
    	    };

    	    _proto.maxHeight = function maxHeight(_maxHeight) {
    	      return this.withOptions({
    	        maxHeight: _maxHeight
    	      });
    	    };

    	    _proto.minHeight = function minHeight(_minHeight) {
    	      return this.withOptions({
    	        minHeight: _minHeight
    	      });
    	    } // Specify width and height in pixels
    	    ;

    	    _proto.size = function size(width, height) {
    	      return this.withOptions({
    	        width: width,
    	        height: height
    	      });
    	    } // Specify blur between 0 and 100
    	    ;

    	    _proto.blur = function blur(_blur) {
    	      return this.withOptions({
    	        blur: _blur
    	      });
    	    };

    	    _proto.sharpen = function sharpen(_sharpen) {
    	      return this.withOptions({
    	        sharpen: _sharpen
    	      });
    	    } // Specify the desired rectangle of the image
    	    ;

    	    _proto.rect = function rect(left, top, width, height) {
    	      return this.withOptions({
    	        rect: {
    	          left: left,
    	          top: top,
    	          width: width,
    	          height: height
    	        }
    	      });
    	    } // Specify the image format of the image. 'jpg', 'pjpg', 'png', 'webp'
    	    ;

    	    _proto.format = function format(_format) {
    	      return this.withOptions({
    	        format: _format
    	      });
    	    };

    	    _proto.invert = function invert(_invert) {
    	      return this.withOptions({
    	        invert: _invert
    	      });
    	    } // Rotation in degrees 0, 90, 180, 270
    	    ;

    	    _proto.orientation = function orientation(_orientation) {
    	      return this.withOptions({
    	        orientation: _orientation
    	      });
    	    } // Compression quality 0-100
    	    ;

    	    _proto.quality = function quality(_quality) {
    	      return this.withOptions({
    	        quality: _quality
    	      });
    	    } // Make it a download link. Parameter is default filename.
    	    ;

    	    _proto.forceDownload = function forceDownload(download) {
    	      return this.withOptions({
    	        download: download
    	      });
    	    } // Flip image horizontally
    	    ;

    	    _proto.flipHorizontal = function flipHorizontal() {
    	      return this.withOptions({
    	        flipHorizontal: true
    	      });
    	    } // Flip image vertically
    	    ;

    	    _proto.flipVertical = function flipVertical() {
    	      return this.withOptions({
    	        flipVertical: true
    	      });
    	    } // Ignore crop/hotspot from image record, even when present
    	    ;

    	    _proto.ignoreImageParams = function ignoreImageParams() {
    	      return this.withOptions({
    	        ignoreImageParams: true
    	      });
    	    };

    	    _proto.fit = function fit(value) {
    	      if (validFits.indexOf(value) === -1) {
    	        throw new Error("Invalid fit mode \"" + value + "\"");
    	      }

    	      return this.withOptions({
    	        fit: value
    	      });
    	    };

    	    _proto.crop = function crop(value) {
    	      if (validCrops.indexOf(value) === -1) {
    	        throw new Error("Invalid crop mode \"" + value + "\"");
    	      }

    	      return this.withOptions({
    	        crop: value
    	      });
    	    } // Saturation
    	    ;

    	    _proto.saturation = function saturation(_saturation) {
    	      return this.withOptions({
    	        saturation: _saturation
    	      });
    	    };

    	    _proto.auto = function auto(value) {
    	      if (validAutoModes.indexOf(value) === -1) {
    	        throw new Error("Invalid auto mode \"" + value + "\"");
    	      }

    	      return this.withOptions({
    	        auto: value
    	      });
    	    } // Specify the number of pixels to pad the image
    	    ;

    	    _proto.pad = function pad(_pad) {
    	      return this.withOptions({
    	        pad: _pad
    	      });
    	    } // Gets the url based on the submitted parameters
    	    ;

    	    _proto.url = function url() {
    	      return urlForImage(this.options);
    	    } // Alias for url()
    	    ;

    	    _proto.toString = function toString() {
    	      return this.url();
    	    };

    	    return ImageUrlBuilder;
    	  }();

    	  return urlBuilder;

    	}));
    	
    } (imageUrl_umd));

    var imageUrlBuilder = imageUrl_umdExports;

    /*! get-video-id v3.6.5 | @license MIT © Michael Wuergler | https://github.com/radiovisual/get-video-id */
    /**
     * Strip away any remaining parameters following `?` or `/` or '&' for YouTube shortcode strings.
     *
     * @note this function is not meant to work with url strings containing a protocol like https://
     * @param {String} shortcodeString - the parameter string
     * @returns {String}
     */
    function stripParameters(shortcodeString) {
      // Split parameters or split folder separator
      if (shortcodeString.includes('?')) {
        shortcodeString = shortcodeString.split('?')[0];
      }

      if (shortcodeString.includes('/')) {
        shortcodeString = shortcodeString.split('/')[0];
      }

      if (shortcodeString.includes('&')) {
        shortcodeString = shortcodeString.split('&')[0];
      }

      return shortcodeString;
    }
    /**
     * Get the Youtube Video id.
     * @param {string} youtubeStr - the url from which you want to extract the id
     * @returns {string|undefined}
     */


    function youtube(youtubeString) {
      var string_ = youtubeString; // Remove time hash at the end of the string

      string_ = string_.replace(/#t=.*$/, ''); // Strip the leading protocol

      string_ = string_.replace(/^https?:\/\//, ''); // Shortcode

      var shortcode = /youtube:\/\/|youtu\.be\/|y2u\.be\//g;

      if (shortcode.test(string_)) {
        var shortcodeid = string_.split(shortcode)[1];
        return stripParameters(shortcodeid);
      } // Shorts


      var shortsUrl = /\/shorts\//g;

      if (shortsUrl.test(string_)) {
        return stripParameters(string_.split(shortsUrl)[1]);
      } // V= or vi=


      var parameterv = /v=|vi=/g;

      if (parameterv.test(string_)) {
        var array = string_.split(parameterv);
        return stripParameters(array[1].split('&')[0]);
      } // /v/ or /vi/ or /watch/


      var inlinev = /\/v\/|\/vi\/|\/watch\//g;

      if (inlinev.test(string_)) {
        var inlineid = string_.split(inlinev)[1];
        return stripParameters(inlineid);
      } // Format an_webp


      var parameterwebp = /\/an_webp\//g;

      if (parameterwebp.test(string_)) {
        var webp = string_.split(parameterwebp)[1];
        return stripParameters(webp);
      } // /e/


      var eformat = /\/e\//g;

      if (eformat.test(string_)) {
        var estring = string_.split(eformat)[1];
        return stripParameters(estring);
      } // Embed


      var embedreg = /\/embed\//g;

      if (embedreg.test(string_)) {
        var embedid = string_.split(embedreg)[1];
        return stripParameters(embedid);
      } // ignore /user/username pattern


      var usernamereg = /\/user\/([a-zA-Z\d]*)$/g;

      if (usernamereg.test(string_)) {
        return undefined;
      } // User


      var userreg = /\/user\/(?!.*videos)/g;

      if (userreg.test(string_)) {
        var elements = string_.split('/');
        return stripParameters(elements.pop());
      } // Attribution_link


      var attrreg = /\/attribution_link\?.*v%3D([^%&]*)(%26|&|$)/;

      if (attrreg.test(string_)) {
        return stripParameters(string_.match(attrreg)[1]);
      }

      return undefined;
    }

    function _slicedToArray(arr, i) {
      return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest();
    }

    function _arrayWithHoles(arr) {
      if (Array.isArray(arr)) return arr;
    }

    function _iterableToArrayLimit(arr, i) {
      var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"];

      if (_i == null) return;
      var _arr = [];
      var _n = true;
      var _d = false;

      var _s, _e;

      try {
        for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) {
          _arr.push(_s.value);

          if (i && _arr.length === i) break;
        }
      } catch (err) {
        _d = true;
        _e = err;
      } finally {
        try {
          if (!_n && _i["return"] != null) _i["return"]();
        } finally {
          if (_d) throw _e;
        }
      }

      return _arr;
    }

    function _unsupportedIterableToArray(o, minLen) {
      if (!o) return;
      if (typeof o === "string") return _arrayLikeToArray(o, minLen);
      var n = Object.prototype.toString.call(o).slice(8, -1);
      if (n === "Object" && o.constructor) n = o.constructor.name;
      if (n === "Map" || n === "Set") return Array.from(o);
      if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
    }

    function _arrayLikeToArray(arr, len) {
      if (len == null || len > arr.length) len = arr.length;

      for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i];

      return arr2;
    }

    function _nonIterableRest() {
      throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
    }

    /**
     * Get the vimeo id.
     *
     * @param {String} vimeoString the url from which you want to extract the id
     * @returns {String|undefined}
     */
    function vimeo(vimeoString) {
      var string_ = vimeoString;

      if (string_.includes('#')) {
        var _string_$split = string_.split('#');

        var _string_$split2 = _slicedToArray(_string_$split, 1);

        string_ = _string_$split2[0];
      }

      if (string_.includes('?') && !string_.includes('clip_id=')) {
        var _string_$split3 = string_.split('?');

        var _string_$split4 = _slicedToArray(_string_$split3, 1);

        string_ = _string_$split4[0];
      }

      var id;
      var array;
      var event = /https?:\/\/vimeo\.com\/event\/(\d+)$/;
      var eventMatches = event.exec(string_);

      if (eventMatches && eventMatches[1]) {
        return eventMatches[1];
      }

      var primary = /https?:\/\/vimeo\.com\/(\d+)/;
      var matches = primary.exec(string_);

      if (matches && matches[1]) {
        return matches[1];
      }

      var vimeoPipe = ['https?://player.vimeo.com/video/[0-9]+$', 'https?://vimeo.com/channels', 'groups', 'album'].join('|');
      var vimeoRegex = new RegExp(vimeoPipe, 'gim');

      if (vimeoRegex.test(string_)) {
        array = string_.split('/');

        if (array && array.length > 0) {
          id = array.pop();
        }
      } else if (/clip_id=/gim.test(string_)) {
        array = string_.split('clip_id=');

        if (array && array.length > 0) {
          var _array$1$split = array[1].split('&');

          var _array$1$split2 = _slicedToArray(_array$1$split, 1);

          id = _array$1$split2[0];
        }
      }

      return id;
    }

    /**
     * Get the vine id.
     * @param {string} string_ - the url from which you want to extract the id
     * @returns {string|undefined}
     */
    function vine(string_) {
      var regex = /https:\/\/vine\.co\/v\/([a-zA-Z\d]*)\/?/;
      var matches = regex.exec(string_);

      if (matches && matches.length > 1) {
        return matches[1];
      }

      return undefined;
    }

    /**
     * Get the VideoPress id.
     * @param {string} urlString - the url from which you want to extract the id
     * @returns {string|undefined}
     */
    function videopress(urlString) {
      var idRegex;

      if (urlString.includes('embed')) {
        idRegex = /embed\/(\w{8})/;
        return urlString.match(idRegex)[1];
      }

      idRegex = /\/v\/(\w{8})/;
      var matches = urlString.match(idRegex);

      if (matches && matches.length > 0) {
        return matches[1];
      }

      return undefined;
    }

    /**
     * Get the Microsoft Stream id.
     * @param {string} urlString - the url from which you want to extract the id
     * @returns {string|undefined}
     */
    function microsoftStream(urlString) {
      var regex = urlString.includes('embed') ? /https:\/\/web\.microsoftstream\.com\/embed\/video\/([a-zA-Z\d-]*)\/?/ : /https:\/\/web\.microsoftstream\.com\/video\/([a-zA-Z\d-]*)\/?/;
      var matches = regex.exec(urlString);

      if (matches && matches.length > 1) {
        return matches[1];
      }

      return undefined;
    }

    /**
     * Get the tiktok id.
     * @param {string} urlString - the url from which you want to extract the id
     * @returns {string|undefined}
     */
    function tiktok(urlString) {
      // Parse basic url and embeds
      var basicReg = /tiktok\.com(.*)\/video\/(\d+)/gm;
      var basicParsed = basicReg.exec(urlString);

      if (basicParsed && basicParsed.length > 2) {
        return basicParsed[2];
      }

      return undefined;
    }

    /**
     * Get the dailymotion id.
     * @param {string} urlString - the url from which you want to extract the id
     * @returns {string|undefined}
     */
    function dailymotion(urlString) {
      // Parse basic url and embeds
      var basicReg = /dailymotion\.com(.*)(video)\/([a-zA-Z\d]+)/gm;
      var basicParsed = basicReg.exec(urlString);

      if (basicParsed) {
        return basicParsed[3];
      } // Parse shortlink


      var shortRegex = /dai\.ly\/([a-zA-Z\d]+)/gm;
      var shortParsed = shortRegex.exec(urlString);

      if (shortParsed && shortParsed.length > 1) {
        return shortParsed[1];
      } // Dynamic link


      var dynamicRegex = /dailymotion\.com(.*)video=([a-zA-Z\d]+)/gm;
      var dynamicParsed = dynamicRegex.exec(urlString);

      if (dynamicParsed && dynamicParsed.length > 2) {
        return dynamicParsed[2];
      }

      return undefined;
    }

    /**
     * Get the value assigned to a "src" attribute in a string, or undefined.
     * @param {String} input
     * @returns {String|undefined}
     */
    function getSrc(input) {
      if (typeof input !== 'string') {
        throw new TypeError('getSrc expected a string');
      }

      var srcRegEx = /src="(.*?)"/gm;
      var matches = srcRegEx.exec(input);

      if (matches && matches.length >= 2) {
        return matches[1];
      }

      return undefined;
    }

    /**
     * Get the id and service from a video url.
     * @param {String} urlString - the url from which you want to extract the id
     * @returns {Object}
     */

    function getVideoId(urlString) {
      if (typeof urlString !== 'string') {
        throw new TypeError('get-video-id expects a string');
      }

      var string_ = urlString;

      if (/<iframe/gi.test(string_)) {
        string_ = getSrc(string_) || '';
      } // Remove surrounding whitespaces or linefeeds


      string_ = string_.trim(); // Remove the '-nocookie' flag from youtube urls

      string_ = string_.replace('-nocookie', ''); // Remove any leading `www.`

      string_ = string_.replace('/www.', '/');
      var metadata = {
        id: null,
        service: null
      }; // Try to handle google redirection uri

      if (/\/\/google/.test(string_)) {
        // Find the redirection uri
        var matches = string_.match(/url=([^&]+)&/); // Decode the found uri and replace current url string - continue with final link

        if (matches) {
          // JavaScript can get encoded URI
          string_ = decodeURIComponent(matches[1]);
        }
      }

      if (/youtube|youtu\.be|y2u\.be|i.ytimg\./.test(string_)) {
        metadata = {
          id: youtube(string_),
          service: 'youtube'
        };
      } else if (/vimeo/.test(string_)) {
        metadata = {
          id: vimeo(string_),
          service: 'vimeo'
        };
      } else if (/vine/.test(string_)) {
        metadata = {
          id: vine(string_),
          service: 'vine'
        };
      } else if (/videopress/.test(string_)) {
        metadata = {
          id: videopress(string_),
          service: 'videopress'
        };
      } else if (/microsoftstream/.test(string_)) {
        metadata = {
          id: microsoftStream(string_),
          service: 'microsoftstream'
        };
      } else if (/tiktok\.com/.test(string_)) {
        metadata = {
          id: tiktok(string_),
          service: 'tiktok'
        };
      } else if (/(dailymotion\.com|dai\.ly)/.test(string_)) {
        metadata = {
          id: dailymotion(string_),
          service: 'dailymotion'
        };
      }

      return metadata;
    }

    const client = sanityClient_default({
      projectId: "s581o0va",
      dataset: "rfgen-live",
      token: "", // or leave blank to be anonymous user
      useCdn: true, // `false` if you want to ensure fresh data
    });

    const h = blocksToHtml_1.h;

    const serializers = {
      marks: {
        link: (props) =>
          h(
            "a",
            { target: "_blank", rel: "noreferrer", href: props.mark.href },
            props.children
          ),
      },
      types: {
        embed: (props) => {
          // YOUTUBE
          if (get_1(props, "node.url", "").includes("youtube")) {
            return h(
              "div",
              { className: "embed-container" },
              h("iframe", {
                width: "720",
                height: "480",
                src:
                  "https://www.youtube.com/embed/" + getVideoId(props.node.url).id,
                frameborder: "no",
                allow:
                  "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture",
                allowfullscreen: true,
              })
            )
          }
          // VIMEO
          if (get_1(props, "node.url", "").includes("vimeo")) {
            return h(
              "div",
              { className: "embed-container" },
              h("iframe", {
                width: "720",
                height: "480",
                src:
                  "https://player.vimeo.com/video/" + getVideoId(props.node.url).id,
                frameborder: "no",
                byline: false,
                color: "#ffffff",
                allow: "autoplay; fullscreen",
                allowfullscreen: true,
              })
            )
          }
          // SOUNDCLOUD
          if (get_1(props, "node.url", "").includes("soundcloud")) {
            return h(
              "div",
              { className: "soundcloud-container" },
              h("iframe", {
                width: "100%",
                height: "300",
                src:
                  "https://w.soundcloud.com/player/?url=" +
                  props.node.url +
                  "&color=%23fffff",
                frameborder: "no",
                scrolling: "no",
                allow: "autoplay",
              })
            )
          }
        },
      },
    };

    const renderBlockText = (text) =>
      blocksToHtml_1({
        blocks: text,
        serializers: serializers,
        projectId: "s581o0va",
        dataset: "rfgen-live",
        imageOptions: { w: 720, h: 500, fit: "max" },
      });

    const toPlainText = (blocks = []) => {
      return (
        blocks
          // loop through each block
          .map((block) => {
            // if it's not a text block with children,
            // return nothing
            if (block._type !== "block" || !block.children) {
              return ""
            }
            // loop through the children spans, and join the
            // text strings
            return block.children.map((child) => child.text).join("")
          })
          // join the parapgraphs leaving split by two linebreaks
          .join("\n\n")
      )
    };

    const builder = imageUrlBuilder(client);

    const urlFor = (source) => builder.image(source);

    const sanitizePost = (res) => {
      return {
        id: get_1(res, "_id", ""),
        slug: get_1(res, "slug", ""),
        category: get_1(res, "category", ""),
        satoshiIndex: get_1(res, "satoshiIndex", 0),
        title: {
          english: get_1(res, "en_title", ""),
          arabic: get_1(res, "ar_title", ""),
        },
        content: {
          english: get_1(res, "en_content", []),
          arabic: get_1(res, "ar_content", []),
        },
        mainImage: get_1(res, "mainImage", false),
        videoLink: get_1(res, "videoLink", false),
        posterImage: get_1(res, "posterImage", false),
        links: [],
        curatorialTeam: get_1(res, "curatorialTeam", []),
        sharjahTeam: get_1(res, "sharjahTeam", []),
        event: {
          type: get_1(res, "eventType", ""),
          date: get_1(res, "performanceDate", ""),
          simpleDate: get_1(res, "simpleDate", 12),
          startTime: get_1(res, "startTime", ""),
          discussions: get_1(res, "discussions", []),
          performers: get_1(res, "participants", []),
        },
        link: get_1(res, "link", ""),
        publisherName: get_1(res, "publisherName", ""),
      }
    };

    const loadSingleData = async (query, params) => {
      try {
        const res = await client.fetch(query, params);

        if (res === null) {
          return Promise.reject(new Error(404))
        }

        let postConstruction = sanitizePost(res);

        // LINKS >>>
        if (postConstruction.category === "participant") {
          const linksQuery =
            '*[participants[]._ref == $id]{en_title, ar_title, en_content, ar_content, "slug": slug.current, mainImage, "category": _type}';
          postConstruction.links = await client.fetch(linksQuery, {
            id: postConstruction.id,
          });
          postConstruction.links = postConstruction.links.map(sanitizePost);
        } else {
          postConstruction.links = get_1(res, "participants", []).map(sanitizePost);
        }

        return postConstruction
      } catch (err) {
        // Sentry.captureException(err)
        return Promise.reject(new Error(404))
      }
    };

    const isCategoryIntroduciton = (p) => p.category === "categoryIntroduction";

    const loadProgrammeData = async (query, params) => {
      try {
        const res = await client.fetch(query, params);

        if (res === null) {
          return Promise.reject(new Error(404))
        }

        const introduction = remove_1(res, isCategoryIntroduciton);

        let processedEvents = fp.compose(
          fp.groupBy((e) => e.event.simpleDate), // Group by (simple) date
          fp.map(sanitizePost) // Sanetize posts
        )(res);

        return {
          introduction: sanitizePost(introduction[0]),
          events: processedEvents,
        }
      } catch (err) {
        // Sentry.captureException(err)
      }
    };

    const loadSatoshis = async (query) => {
      try {
        const res = await client.fetch(query);
        if (res === null) {
          return Promise.reject(new Error(404))
        }
        return res.map(sanitizePost)
      } catch (err) {
        // Sentry.captureException(err)
        return Promise.reject(new Error(404))
      }
    };

    /* src\Components\MetaData.svelte generated by Svelte v3.58.0 */

    function create_if_block_1$a(ctx) {
    	let title_value;
    	let t0;
    	let meta0;
    	let t1;
    	let meta1;
    	let t2;
    	let meta2;
    	let t3;
    	let meta3;
    	let t4;
    	let meta4;
    	document.title = title_value = /*title*/ ctx[2].english;

    	return {
    		c() {
    			t0 = space();
    			meta0 = element("meta");
    			t1 = space();
    			meta1 = element("meta");
    			t2 = space();
    			meta2 = element("meta");
    			t3 = space();
    			meta3 = element("meta");
    			t4 = space();
    			meta4 = element("meta");
    			attr(meta0, "property", "og:title");
    			attr(meta0, "content", /*title*/ ctx[2].english);
    			attr(meta1, "property", "twitter:title");
    			attr(meta1, "content", /*title*/ ctx[2].english);
    			attr(meta2, "property", "description");
    			attr(meta2, "content", /*description*/ ctx[3].english);
    			attr(meta3, "property", "og:description");
    			attr(meta3, "content", /*description*/ ctx[3].english);
    			attr(meta4, "property", "twitter:description");
    			attr(meta4, "content", /*description*/ ctx[3].english);
    		},
    		m(target, anchor) {
    			insert(target, t0, anchor);
    			insert(target, meta0, anchor);
    			insert(target, t1, anchor);
    			insert(target, meta1, anchor);
    			insert(target, t2, anchor);
    			insert(target, meta2, anchor);
    			insert(target, t3, anchor);
    			insert(target, meta3, anchor);
    			insert(target, t4, anchor);
    			insert(target, meta4, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*title*/ 4 && title_value !== (title_value = /*title*/ ctx[2].english)) {
    				document.title = title_value;
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(t0);
    			if (detaching) detach(meta0);
    			if (detaching) detach(t1);
    			if (detaching) detach(meta1);
    			if (detaching) detach(t2);
    			if (detaching) detach(meta2);
    			if (detaching) detach(t3);
    			if (detaching) detach(meta3);
    			if (detaching) detach(t4);
    			if (detaching) detach(meta4);
    		}
    	};
    }

    // (82:2) {#if $isArabic}
    function create_if_block$c(ctx) {
    	let title_value;
    	let t0;
    	let meta0;
    	let t1;
    	let meta1;
    	let t2;
    	let meta2;
    	let t3;
    	let meta3;
    	let t4;
    	let meta4;
    	document.title = title_value = /*title*/ ctx[2].arabic;

    	return {
    		c() {
    			t0 = space();
    			meta0 = element("meta");
    			t1 = space();
    			meta1 = element("meta");
    			t2 = space();
    			meta2 = element("meta");
    			t3 = space();
    			meta3 = element("meta");
    			t4 = space();
    			meta4 = element("meta");
    			attr(meta0, "property", "og:title");
    			attr(meta0, "content", /*title*/ ctx[2].arabic);
    			attr(meta1, "property", "twitter:title");
    			attr(meta1, "content", /*title*/ ctx[2].arabic);
    			attr(meta2, "property", "description");
    			attr(meta2, "content", /*description*/ ctx[3].arabic);
    			attr(meta3, "property", "og:description");
    			attr(meta3, "content", /*description*/ ctx[3].arabic);
    			attr(meta4, "property", "twitter:description");
    			attr(meta4, "content", /*description*/ ctx[3].arabic);
    		},
    		m(target, anchor) {
    			insert(target, t0, anchor);
    			insert(target, meta0, anchor);
    			insert(target, t1, anchor);
    			insert(target, meta1, anchor);
    			insert(target, t2, anchor);
    			insert(target, meta2, anchor);
    			insert(target, t3, anchor);
    			insert(target, meta3, anchor);
    			insert(target, t4, anchor);
    			insert(target, meta4, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*title*/ 4 && title_value !== (title_value = /*title*/ ctx[2].arabic)) {
    				document.title = title_value;
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(t0);
    			if (detaching) detach(meta0);
    			if (detaching) detach(t1);
    			if (detaching) detach(meta1);
    			if (detaching) detach(t2);
    			if (detaching) detach(meta2);
    			if (detaching) detach(t3);
    			if (detaching) detach(meta3);
    			if (detaching) detach(t4);
    			if (detaching) detach(meta4);
    		}
    	};
    }

    function create_fragment$f(ctx) {
    	let if_block0_anchor;
    	let meta0;
    	let meta1;
    	let meta2;
    	let if_block0 = /*$isEnglish*/ ctx[0] && create_if_block_1$a(ctx);
    	let if_block1 = /*$isArabic*/ ctx[1] && create_if_block$c(ctx);

    	return {
    		c() {
    			if (if_block0) if_block0.c();
    			if_block0_anchor = empty();
    			if (if_block1) if_block1.c();
    			meta0 = element("meta");
    			meta1 = element("meta");
    			meta2 = element("meta");
    			attr(meta0, "property", "image");
    			attr(meta0, "content", /*image*/ ctx[4]);
    			attr(meta1, "property", "og:image");
    			attr(meta1, "content", /*image*/ ctx[4]);
    			attr(meta2, "property", "twitter:image");
    			attr(meta2, "content", /*image*/ ctx[4]);
    		},
    		m(target, anchor) {
    			if (if_block0) if_block0.m(document.head, null);
    			append(document.head, if_block0_anchor);
    			if (if_block1) if_block1.m(document.head, null);
    			append(document.head, meta0);
    			append(document.head, meta1);
    			append(document.head, meta2);
    		},
    		p(ctx, [dirty]) {
    			if (/*$isEnglish*/ ctx[0]) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);
    				} else {
    					if_block0 = create_if_block_1$a(ctx);
    					if_block0.c();
    					if_block0.m(if_block0_anchor.parentNode, if_block0_anchor);
    				}
    			} else if (if_block0) {
    				if_block0.d(1);
    				if_block0 = null;
    			}

    			if (/*$isArabic*/ ctx[1]) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);
    				} else {
    					if_block1 = create_if_block$c(ctx);
    					if_block1.c();
    					if_block1.m(meta0.parentNode, meta0);
    				}
    			} else if (if_block1) {
    				if_block1.d(1);
    				if_block1 = null;
    			}
    		},
    		i: noop$1,
    		o: noop$1,
    		d(detaching) {
    			if (if_block0) if_block0.d(detaching);
    			detach(if_block0_anchor);
    			if (if_block1) if_block1.d(detaching);
    			detach(meta0);
    			detach(meta1);
    			detach(meta2);
    		}
    	};
    }

    function instance$e($$self, $$props, $$invalidate) {
    	let $isEnglish;
    	let $isArabic;
    	component_subscribe($$self, isEnglish, $$value => $$invalidate(0, $isEnglish = $$value));
    	component_subscribe($$self, isArabic, $$value => $$invalidate(1, $isArabic = $$value));
    	let { post = {} } = $$props;

    	const title = {
    		english: (has_1(post, "title.english") && !isEmpty_1(post.title.english)
    		? post.title.english + " / "
    		: "") + get_1(siteInfo, "title.english", "") + " / " + get_1(siteInfo, "satTitle.english", ""),
    		arabic: (has_1(post, "title.arabic") && !isEmpty_1(post.title.arabic)
    		? post.title.arabic + " / "
    		: "") + get_1(siteInfo, "title.arabic", "") + " / " + get_1(siteInfo, "satTitle.arabic", "")
    	};

    	const description = {
    		english: has_1(post, "content.english") && isArray_1(post.content.english) && !isEmpty_1(post.content.english)
    		? truncate_1(toPlainText(post.content.english), { length: 160, separator: /.? +/ })
    		: get_1(siteInfo, "description.english", ""),
    		arabic: has_1(post, "content.arabic") && isArray_1(post.content.arabic) && !isEmpty_1(post.content.arabic)
    		? truncate_1(toPlainText(post.content.arabic), { length: 160, separator: /.? +/ })
    		: get_1(siteInfo, "description.arabic", "")
    	};

    	const image = has_1(post, "mainImage.asset")
    	? urlFor(post.mainImage).quality(80).height(1200).width(1200).auto("format").url()
    	: siteInfo.image;

    	$$self.$$set = $$props => {
    		if ('post' in $$props) $$invalidate(5, post = $$props.post);
    	};

    	return [$isEnglish, $isArabic, title, description, image, post];
    }

    class MetaData extends SvelteComponent {
    	constructor(options) {
    		super();
    		init(this, options, instance$e, create_fragment$f, safe_not_equal, { post: 5 });
    	}
    }

    function cubicOut(t) {
        const f = t - 1.0;
        return f * f * f + 1.0;
    }

    function fade(node, { delay = 0, duration = 400, easing = identity$6 } = {}) {
        const o = +getComputedStyle(node).opacity;
        return {
            delay,
            duration,
            easing,
            css: t => `opacity: ${t * o}`
        };
    }
    function fly(node, { delay = 0, duration = 400, easing = cubicOut, x = 0, y = 0, opacity = 0 } = {}) {
        const style = getComputedStyle(node);
        const target_opacity = +style.opacity;
        const transform = style.transform === 'none' ? '' : style.transform;
        const od = target_opacity * (1 - opacity);
        const [xValue, xUnit] = split_css_unit(x);
        const [yValue, yUnit] = split_css_unit(y);
        return {
            delay,
            duration,
            easing,
            css: (t, u) => `
			transform: ${transform} translate(${(1 - t) * xValue}${xUnit}, ${(1 - t) * yValue}${yUnit});
			opacity: ${target_opacity - (od * u)}`
        };
    }
    function scale(node, { delay = 0, duration = 400, easing = cubicOut, start = 0, opacity = 0 } = {}) {
        const style = getComputedStyle(node);
        const target_opacity = +style.opacity;
        const transform = style.transform === 'none' ? '' : style.transform;
        const sd = 1 - start;
        const od = target_opacity * (1 - opacity);
        return {
            delay,
            duration,
            easing,
            css: (_t, u) => `
			transform: ${transform} scale(${1 - (sd * u)});
			opacity: ${target_opacity - (od * u)}
		`
        };
    }

    /* node_modules\svelte-media-query\src\MediaQuery.svelte generated by Svelte v3.58.0 */
    const get_default_slot_changes = dirty => ({ matches: dirty & /*matches*/ 1 });
    const get_default_slot_context = ctx => ({ matches: /*matches*/ ctx[0] });

    function create_fragment$e(ctx) {
    	let current;
    	const default_slot_template = /*#slots*/ ctx[4].default;
    	const default_slot = create_slot(default_slot_template, ctx, /*$$scope*/ ctx[3], get_default_slot_context);

    	return {
    		c() {
    			if (default_slot) default_slot.c();
    		},
    		m(target, anchor) {
    			if (default_slot) {
    				default_slot.m(target, anchor);
    			}

    			current = true;
    		},
    		p(ctx, [dirty]) {
    			if (default_slot) {
    				if (default_slot.p && (!current || dirty & /*$$scope, matches*/ 9)) {
    					update_slot_base(
    						default_slot,
    						default_slot_template,
    						ctx,
    						/*$$scope*/ ctx[3],
    						!current
    						? get_all_dirty_from_scope(/*$$scope*/ ctx[3])
    						: get_slot_changes(default_slot_template, /*$$scope*/ ctx[3], dirty, get_default_slot_changes),
    						get_default_slot_context
    					);
    				}
    			}
    		},
    		i(local) {
    			if (current) return;
    			transition_in(default_slot, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(default_slot, local);
    			current = false;
    		},
    		d(detaching) {
    			if (default_slot) default_slot.d(detaching);
    		}
    	};
    }

    function instance$d($$self, $$props, $$invalidate) {
    	let { $$slots: slots = {}, $$scope } = $$props;
    	let { query } = $$props;
    	let mql;
    	let mqlListener;
    	let wasMounted = false;
    	let matches = false;

    	onMount(() => {
    		$$invalidate(2, wasMounted = true);

    		return () => {
    			removeActiveListener();
    		};
    	});

    	function addNewListener(query) {
    		mql = window.matchMedia(query);
    		mqlListener = v => $$invalidate(0, matches = v.matches);

    		mql.addEventListener
    		? mql.addEventListener("change", mqlListener)
    		: mql.addListener(mqlListener);

    		$$invalidate(0, matches = mql.matches);
    	}

    	function removeActiveListener() {
    		if (mql && mqlListener) {
    			mql.removeEventListener
    			? mql.removeEventListener("change", mqlListener)
    			: mql.removeListener(mqlListener);
    		}
    	}

    	$$self.$$set = $$props => {
    		if ('query' in $$props) $$invalidate(1, query = $$props.query);
    		if ('$$scope' in $$props) $$invalidate(3, $$scope = $$props.$$scope);
    	};

    	$$self.$$.update = () => {
    		if ($$self.$$.dirty & /*wasMounted, query*/ 6) {
    			{
    				if (wasMounted) {
    					removeActiveListener();
    					addNewListener(query);
    				}
    			}
    		}
    	};

    	return [matches, query, wasMounted, $$scope, slots];
    }

    class MediaQuery extends SvelteComponent {
    	constructor(options) {
    		super();
    		init(this, options, instance$d, create_fragment$e, safe_not_equal, { query: 1 });
    	}
    }

    /* src\Components\Tile.svelte generated by Svelte v3.58.0 */

    function create_else_block_1$1(ctx) {
    	let a;
    	let div0;
    	let t;
    	let div1;
    	let a_href_value;
    	let current;
    	let if_block0 = !/*linkOutActive*/ ctx[6] && create_if_block_14(ctx);
    	let if_block1 = /*post*/ ctx[0].mainImage && /*inView*/ ctx[7] && create_if_block_12$2(ctx);

    	return {
    		c() {
    			a = element("a");
    			div0 = element("div");
    			if (if_block0) if_block0.c();
    			t = space();
    			div1 = element("div");
    			if (if_block1) if_block1.c();
    			attr(div0, "class", "tile-bar svelte-7v1ssr");
    			attr(div1, "class", "tile-image svelte-7v1ssr");
    			toggle_class(div1, "loaded", /*loaded*/ ctx[5]);
    			attr(a, "href", a_href_value = "/" + /*$languagePrefix*/ ctx[10] + "/" + /*post*/ ctx[0].category + "/" + /*post*/ ctx[0].slug);
    		},
    		m(target, anchor) {
    			insert(target, a, anchor);
    			append(a, div0);
    			if (if_block0) if_block0.m(div0, null);
    			append(a, t);
    			append(a, div1);
    			if (if_block1) if_block1.m(div1, null);
    			current = true;
    		},
    		p(ctx, dirty) {
    			if (!/*linkOutActive*/ ctx[6]) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);
    				} else {
    					if_block0 = create_if_block_14(ctx);
    					if_block0.c();
    					if_block0.m(div0, null);
    				}
    			} else if (if_block0) {
    				if_block0.d(1);
    				if_block0 = null;
    			}

    			if (/*post*/ ctx[0].mainImage && /*inView*/ ctx[7]) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);

    					if (dirty & /*post, inView*/ 129) {
    						transition_in(if_block1, 1);
    					}
    				} else {
    					if_block1 = create_if_block_12$2(ctx);
    					if_block1.c();
    					transition_in(if_block1, 1);
    					if_block1.m(div1, null);
    				}
    			} else if (if_block1) {
    				group_outros();

    				transition_out(if_block1, 1, 1, () => {
    					if_block1 = null;
    				});

    				check_outros();
    			}

    			if (!current || dirty & /*loaded*/ 32) {
    				toggle_class(div1, "loaded", /*loaded*/ ctx[5]);
    			}

    			if (!current || dirty & /*$languagePrefix, post*/ 1025 && a_href_value !== (a_href_value = "/" + /*$languagePrefix*/ ctx[10] + "/" + /*post*/ ctx[0].category + "/" + /*post*/ ctx[0].slug)) {
    				attr(a, "href", a_href_value);
    			}
    		},
    		i(local) {
    			if (current) return;
    			transition_in(if_block1);
    			current = true;
    		},
    		o(local) {
    			transition_out(if_block1);
    			current = false;
    		},
    		d(detaching) {
    			if (detaching) detach(a);
    			if (if_block0) if_block0.d();
    			if (if_block1) if_block1.d();
    		}
    	};
    }

    // (391:4) {#if post.category === 'writing' && !post.isSticky}
    function create_if_block$b(ctx) {
    	let div3;
    	let div0;
    	let t0;
    	let div1;
    	let t1;
    	let div2;
    	let div2_class_value;
    	let current;
    	let mounted;
    	let dispose;
    	let if_block0 = !/*linkOutActive*/ ctx[6] && create_if_block_9$2(ctx);
    	let if_block1 = /*post*/ ctx[0].mainImage && /*inView*/ ctx[7] && create_if_block_7$2(ctx);
    	let if_block2 = /*linkOutActive*/ ctx[6] && create_if_block_1$9(ctx);

    	return {
    		c() {
    			div3 = element("div");
    			div0 = element("div");
    			if (if_block0) if_block0.c();
    			t0 = space();
    			div1 = element("div");
    			if (if_block1) if_block1.c();
    			t1 = space();
    			div2 = element("div");
    			if (if_block2) if_block2.c();
    			attr(div0, "class", "tile-bar svelte-7v1ssr");
    			attr(div1, "class", "tile-image svelte-7v1ssr");
    			toggle_class(div1, "loaded", /*loaded*/ ctx[5]);
    			attr(div2, "class", div2_class_value = "tile-overlay " + /*color*/ ctx[4] + " svelte-7v1ssr");
    			toggle_class(div2, "active", /*linkOutActive*/ ctx[6]);
    		},
    		m(target, anchor) {
    			insert(target, div3, anchor);
    			append(div3, div0);
    			if (if_block0) if_block0.m(div0, null);
    			append(div3, t0);
    			append(div3, div1);
    			if (if_block1) if_block1.m(div1, null);
    			append(div3, t1);
    			append(div3, div2);
    			if (if_block2) if_block2.m(div2, null);
    			current = true;

    			if (!mounted) {
    				dispose = listen$1(div3, "click", /*click_handler*/ ctx[15]);
    				mounted = true;
    			}
    		},
    		p(ctx, dirty) {
    			if (!/*linkOutActive*/ ctx[6]) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);
    				} else {
    					if_block0 = create_if_block_9$2(ctx);
    					if_block0.c();
    					if_block0.m(div0, null);
    				}
    			} else if (if_block0) {
    				if_block0.d(1);
    				if_block0 = null;
    			}

    			if (/*post*/ ctx[0].mainImage && /*inView*/ ctx[7]) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);

    					if (dirty & /*post, inView*/ 129) {
    						transition_in(if_block1, 1);
    					}
    				} else {
    					if_block1 = create_if_block_7$2(ctx);
    					if_block1.c();
    					transition_in(if_block1, 1);
    					if_block1.m(div1, null);
    				}
    			} else if (if_block1) {
    				group_outros();

    				transition_out(if_block1, 1, 1, () => {
    					if_block1 = null;
    				});

    				check_outros();
    			}

    			if (!current || dirty & /*loaded*/ 32) {
    				toggle_class(div1, "loaded", /*loaded*/ ctx[5]);
    			}

    			if (/*linkOutActive*/ ctx[6]) {
    				if (if_block2) {
    					if_block2.p(ctx, dirty);

    					if (dirty & /*linkOutActive*/ 64) {
    						transition_in(if_block2, 1);
    					}
    				} else {
    					if_block2 = create_if_block_1$9(ctx);
    					if_block2.c();
    					transition_in(if_block2, 1);
    					if_block2.m(div2, null);
    				}
    			} else if (if_block2) {
    				if_block2.d(1);
    				if_block2 = null;
    			}

    			if (!current || dirty & /*color*/ 16 && div2_class_value !== (div2_class_value = "tile-overlay " + /*color*/ ctx[4] + " svelte-7v1ssr")) {
    				attr(div2, "class", div2_class_value);
    			}

    			if (!current || dirty & /*color, linkOutActive*/ 80) {
    				toggle_class(div2, "active", /*linkOutActive*/ ctx[6]);
    			}
    		},
    		i(local) {
    			if (current) return;
    			transition_in(if_block1);
    			transition_in(if_block2);
    			current = true;
    		},
    		o(local) {
    			transition_out(if_block1);
    			current = false;
    		},
    		d(detaching) {
    			if (detaching) detach(div3);
    			if (if_block0) if_block0.d();
    			if (if_block1) if_block1.d();
    			if (if_block2) if_block2.d();
    			mounted = false;
    			dispose();
    		}
    	};
    }

    // (462:10) {#if !linkOutActive}
    function create_if_block_14(ctx) {
    	let div;
    	let t;
    	let if_block0 = /*$isEnglish*/ ctx[8] && /*post*/ ctx[0].en_title && create_if_block_16(ctx);
    	let if_block1 = /*$isArabic*/ ctx[9] && /*post*/ ctx[0].ar_title && create_if_block_15(ctx);

    	return {
    		c() {
    			div = element("div");
    			if (if_block0) if_block0.c();
    			t = space();
    			if (if_block1) if_block1.c();
    			attr(div, "class", "tile-title svelte-7v1ssr");
    			toggle_class(div, "loaded", /*loaded*/ ctx[5]);
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);
    			if (if_block0) if_block0.m(div, null);
    			append(div, t);
    			if (if_block1) if_block1.m(div, null);
    		},
    		p(ctx, dirty) {
    			if (/*$isEnglish*/ ctx[8] && /*post*/ ctx[0].en_title) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);
    				} else {
    					if_block0 = create_if_block_16(ctx);
    					if_block0.c();
    					if_block0.m(div, t);
    				}
    			} else if (if_block0) {
    				if_block0.d(1);
    				if_block0 = null;
    			}

    			if (/*$isArabic*/ ctx[9] && /*post*/ ctx[0].ar_title) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);
    				} else {
    					if_block1 = create_if_block_15(ctx);
    					if_block1.c();
    					if_block1.m(div, null);
    				}
    			} else if (if_block1) {
    				if_block1.d(1);
    				if_block1 = null;
    			}

    			if (dirty & /*loaded*/ 32) {
    				toggle_class(div, "loaded", /*loaded*/ ctx[5]);
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(div);
    			if (if_block0) if_block0.d();
    			if (if_block1) if_block1.d();
    		}
    	};
    }

    // (464:14) {#if $isEnglish && post.en_title}
    function create_if_block_16(ctx) {
    	let t_value = /*post*/ ctx[0].en_title + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 1 && t_value !== (t_value = /*post*/ ctx[0].en_title + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (465:14) {#if $isArabic && post.ar_title}
    function create_if_block_15(ctx) {
    	let t_value = /*post*/ ctx[0].ar_title + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 1 && t_value !== (t_value = /*post*/ ctx[0].ar_title + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (470:10) {#if post.mainImage && inView}
    function create_if_block_12$2(ctx) {
    	let mediaquery;
    	let current;

    	mediaquery = new MediaQuery({
    			props: {
    				query: "(min-width: 800px)",
    				$$slots: {
    					default: [
    						create_default_slot_2,
    						({ matches }) => ({ 20: matches }),
    						({ matches }) => matches ? 1048576 : 0
    					]
    				},
    				$$scope: { ctx }
    			}
    		});

    	return {
    		c() {
    			create_component(mediaquery.$$.fragment);
    		},
    		m(target, anchor) {
    			mount_component(mediaquery, target, anchor);
    			current = true;
    		},
    		p(ctx, dirty) {
    			const mediaquery_changes = {};

    			if (dirty & /*$$scope, post, $isEnglish, loaded, matches*/ 3146017) {
    				mediaquery_changes.$$scope = { dirty, ctx };
    			}

    			mediaquery.$set(mediaquery_changes);
    		},
    		i(local) {
    			if (current) return;
    			transition_in(mediaquery.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(mediaquery.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			destroy_component(mediaquery, detaching);
    		}
    	};
    }

    // (482:14) {:else}
    function create_else_block_2(ctx) {
    	let img;
    	let img_src_value;
    	let img_alt_value;
    	let mounted;
    	let dispose;

    	return {
    		c() {
    			img = element("img");
    			if (!src_url_equal(img.src, img_src_value = urlFor(/*post*/ ctx[0].mainImage).height(300).width(600).quality(80).auto('format').url())) attr(img, "src", img_src_value);

    			attr(img, "alt", img_alt_value = /*$isEnglish*/ ctx[8]
    			? /*post*/ ctx[0].en_title
    			: /*post*/ ctx[0].ar_title);

    			attr(img, "class", "svelte-7v1ssr");
    		},
    		m(target, anchor) {
    			insert(target, img, anchor);

    			if (!mounted) {
    				dispose = listen$1(img, "load", /*load_handler_3*/ ctx[17]);
    				mounted = true;
    			}
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 1 && !src_url_equal(img.src, img_src_value = urlFor(/*post*/ ctx[0].mainImage).height(300).width(600).quality(80).auto('format').url())) {
    				attr(img, "src", img_src_value);
    			}

    			if (dirty & /*$isEnglish, post*/ 257 && img_alt_value !== (img_alt_value = /*$isEnglish*/ ctx[8]
    			? /*post*/ ctx[0].en_title
    			: /*post*/ ctx[0].ar_title)) {
    				attr(img, "alt", img_alt_value);
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(img);
    			mounted = false;
    			dispose();
    		}
    	};
    }

    // (472:14) {#if matches}
    function create_if_block_13(ctx) {
    	let img;
    	let img_src_value;
    	let img_alt_value;
    	let mounted;
    	let dispose;

    	return {
    		c() {
    			img = element("img");
    			if (!src_url_equal(img.src, img_src_value = urlFor(/*post*/ ctx[0].mainImage).height(320).width(/*imgWidth*/ ctx[11]).quality(80).auto('format').url())) attr(img, "src", img_src_value);

    			attr(img, "alt", img_alt_value = /*$isEnglish*/ ctx[8]
    			? /*post*/ ctx[0].en_title
    			: /*post*/ ctx[0].ar_title);

    			attr(img, "class", "svelte-7v1ssr");
    		},
    		m(target, anchor) {
    			insert(target, img, anchor);

    			if (!mounted) {
    				dispose = listen$1(img, "load", /*load_handler_2*/ ctx[16]);
    				mounted = true;
    			}
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 1 && !src_url_equal(img.src, img_src_value = urlFor(/*post*/ ctx[0].mainImage).height(320).width(/*imgWidth*/ ctx[11]).quality(80).auto('format').url())) {
    				attr(img, "src", img_src_value);
    			}

    			if (dirty & /*$isEnglish, post*/ 257 && img_alt_value !== (img_alt_value = /*$isEnglish*/ ctx[8]
    			? /*post*/ ctx[0].en_title
    			: /*post*/ ctx[0].ar_title)) {
    				attr(img, "alt", img_alt_value);
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(img);
    			mounted = false;
    			dispose();
    		}
    	};
    }

    // (471:12) <MediaQuery query="(min-width: 800px)" let:matches>
    function create_default_slot_2(ctx) {
    	let if_block_anchor;

    	function select_block_type_2(ctx, dirty) {
    		if (/*matches*/ ctx[20]) return create_if_block_13;
    		return create_else_block_2;
    	}

    	let current_block_type = select_block_type_2(ctx);
    	let if_block = current_block_type(ctx);

    	return {
    		c() {
    			if_block.c();
    			if_block_anchor = empty();
    		},
    		m(target, anchor) {
    			if_block.m(target, anchor);
    			insert(target, if_block_anchor, anchor);
    		},
    		p(ctx, dirty) {
    			if (current_block_type === (current_block_type = select_block_type_2(ctx)) && if_block) {
    				if_block.p(ctx, dirty);
    			} else {
    				if_block.d(1);
    				if_block = current_block_type(ctx);

    				if (if_block) {
    					if_block.c();
    					if_block.m(if_block_anchor.parentNode, if_block_anchor);
    				}
    			}
    		},
    		d(detaching) {
    			if_block.d(detaching);
    			if (detaching) detach(if_block_anchor);
    		}
    	};
    }

    // (394:10) {#if !linkOutActive}
    function create_if_block_9$2(ctx) {
    	let div;
    	let t;
    	let if_block0 = /*$isEnglish*/ ctx[8] && create_if_block_11$2(ctx);
    	let if_block1 = /*$isArabic*/ ctx[9] && create_if_block_10$2(ctx);

    	return {
    		c() {
    			div = element("div");
    			if (if_block0) if_block0.c();
    			t = space();
    			if (if_block1) if_block1.c();
    			attr(div, "class", "tile-title svelte-7v1ssr");
    			toggle_class(div, "loaded", /*loaded*/ ctx[5]);
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);
    			if (if_block0) if_block0.m(div, null);
    			append(div, t);
    			if (if_block1) if_block1.m(div, null);
    		},
    		p(ctx, dirty) {
    			if (/*$isEnglish*/ ctx[8]) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);
    				} else {
    					if_block0 = create_if_block_11$2(ctx);
    					if_block0.c();
    					if_block0.m(div, t);
    				}
    			} else if (if_block0) {
    				if_block0.d(1);
    				if_block0 = null;
    			}

    			if (/*$isArabic*/ ctx[9]) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);
    				} else {
    					if_block1 = create_if_block_10$2(ctx);
    					if_block1.c();
    					if_block1.m(div, null);
    				}
    			} else if (if_block1) {
    				if_block1.d(1);
    				if_block1 = null;
    			}

    			if (dirty & /*loaded*/ 32) {
    				toggle_class(div, "loaded", /*loaded*/ ctx[5]);
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(div);
    			if (if_block0) if_block0.d();
    			if (if_block1) if_block1.d();
    		}
    	};
    }

    // (396:14) {#if $isEnglish}
    function create_if_block_11$2(ctx) {
    	let t_value = /*post*/ ctx[0].en_title + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 1 && t_value !== (t_value = /*post*/ ctx[0].en_title + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (397:14) {#if $isArabic}
    function create_if_block_10$2(ctx) {
    	let t_value = /*post*/ ctx[0].ar_title + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 1 && t_value !== (t_value = /*post*/ ctx[0].ar_title + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (402:10) {#if post.mainImage && inView}
    function create_if_block_7$2(ctx) {
    	let mediaquery;
    	let current;

    	mediaquery = new MediaQuery({
    			props: {
    				query: "(min-width: 800px)",
    				$$slots: {
    					default: [
    						create_default_slot_1,
    						({ matches }) => ({ 20: matches }),
    						({ matches }) => matches ? 1048576 : 0
    					]
    				},
    				$$scope: { ctx }
    			}
    		});

    	return {
    		c() {
    			create_component(mediaquery.$$.fragment);
    		},
    		m(target, anchor) {
    			mount_component(mediaquery, target, anchor);
    			current = true;
    		},
    		p(ctx, dirty) {
    			const mediaquery_changes = {};

    			if (dirty & /*$$scope, post, $isEnglish, loaded, matches*/ 3146017) {
    				mediaquery_changes.$$scope = { dirty, ctx };
    			}

    			mediaquery.$set(mediaquery_changes);
    		},
    		i(local) {
    			if (current) return;
    			transition_in(mediaquery.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(mediaquery.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			destroy_component(mediaquery, detaching);
    		}
    	};
    }

    // (414:14) {:else}
    function create_else_block$5(ctx) {
    	let img;
    	let img_src_value;
    	let img_alt_value;
    	let mounted;
    	let dispose;

    	return {
    		c() {
    			img = element("img");
    			if (!src_url_equal(img.src, img_src_value = urlFor(/*post*/ ctx[0].mainImage).height(300).width(600).quality(80).auto('format').url())) attr(img, "src", img_src_value);

    			attr(img, "alt", img_alt_value = /*$isEnglish*/ ctx[8]
    			? /*post*/ ctx[0].en_title
    			: /*post*/ ctx[0].ar_title);

    			attr(img, "class", "svelte-7v1ssr");
    		},
    		m(target, anchor) {
    			insert(target, img, anchor);

    			if (!mounted) {
    				dispose = listen$1(img, "load", /*load_handler_1*/ ctx[14]);
    				mounted = true;
    			}
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 1 && !src_url_equal(img.src, img_src_value = urlFor(/*post*/ ctx[0].mainImage).height(300).width(600).quality(80).auto('format').url())) {
    				attr(img, "src", img_src_value);
    			}

    			if (dirty & /*$isEnglish, post*/ 257 && img_alt_value !== (img_alt_value = /*$isEnglish*/ ctx[8]
    			? /*post*/ ctx[0].en_title
    			: /*post*/ ctx[0].ar_title)) {
    				attr(img, "alt", img_alt_value);
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(img);
    			mounted = false;
    			dispose();
    		}
    	};
    }

    // (404:14) {#if matches}
    function create_if_block_8$2(ctx) {
    	let img;
    	let img_src_value;
    	let img_alt_value;
    	let mounted;
    	let dispose;

    	return {
    		c() {
    			img = element("img");
    			if (!src_url_equal(img.src, img_src_value = urlFor(/*post*/ ctx[0].mainImage).height(320).width(/*imgWidth*/ ctx[11]).quality(80).auto('format').url())) attr(img, "src", img_src_value);

    			attr(img, "alt", img_alt_value = /*$isEnglish*/ ctx[8]
    			? /*post*/ ctx[0].en_title
    			: /*post*/ ctx[0].ar_title);

    			attr(img, "class", "svelte-7v1ssr");
    		},
    		m(target, anchor) {
    			insert(target, img, anchor);

    			if (!mounted) {
    				dispose = listen$1(img, "load", /*load_handler*/ ctx[13]);
    				mounted = true;
    			}
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 1 && !src_url_equal(img.src, img_src_value = urlFor(/*post*/ ctx[0].mainImage).height(320).width(/*imgWidth*/ ctx[11]).quality(80).auto('format').url())) {
    				attr(img, "src", img_src_value);
    			}

    			if (dirty & /*$isEnglish, post*/ 257 && img_alt_value !== (img_alt_value = /*$isEnglish*/ ctx[8]
    			? /*post*/ ctx[0].en_title
    			: /*post*/ ctx[0].ar_title)) {
    				attr(img, "alt", img_alt_value);
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(img);
    			mounted = false;
    			dispose();
    		}
    	};
    }

    // (403:12) <MediaQuery query="(min-width: 800px)" let:matches>
    function create_default_slot_1(ctx) {
    	let if_block_anchor;

    	function select_block_type_1(ctx, dirty) {
    		if (/*matches*/ ctx[20]) return create_if_block_8$2;
    		return create_else_block$5;
    	}

    	let current_block_type = select_block_type_1(ctx);
    	let if_block = current_block_type(ctx);

    	return {
    		c() {
    			if_block.c();
    			if_block_anchor = empty();
    		},
    		m(target, anchor) {
    			if_block.m(target, anchor);
    			insert(target, if_block_anchor, anchor);
    		},
    		p(ctx, dirty) {
    			if (current_block_type === (current_block_type = select_block_type_1(ctx)) && if_block) {
    				if_block.p(ctx, dirty);
    			} else {
    				if_block.d(1);
    				if_block = current_block_type(ctx);

    				if (if_block) {
    					if_block.c();
    					if_block.m(if_block_anchor.parentNode, if_block_anchor);
    				}
    			}
    		},
    		d(detaching) {
    			if_block.d(detaching);
    			if (detaching) detach(if_block_anchor);
    		}
    	};
    }

    // (429:10) {#if linkOutActive}
    function create_if_block_1$9(ctx) {
    	let show_if = !isEmpty_1(/*post*/ ctx[0].participants);
    	let t0;
    	let p0;
    	let t1;
    	let p0_intro;
    	let t2;
    	let p1;
    	let t3;
    	let p1_intro;
    	let if_block0 = show_if && create_if_block_6$2(ctx);
    	let if_block1 = /*$isEnglish*/ ctx[8] && create_if_block_5$3(ctx);
    	let if_block2 = /*$isArabic*/ ctx[9] && create_if_block_4$3(ctx);
    	let if_block3 = /*$isEnglish*/ ctx[8] && create_if_block_3$4(ctx);
    	let if_block4 = /*$isArabic*/ ctx[9] && /*post*/ ctx[0].ar_linkFile && create_if_block_2$4(ctx);

    	return {
    		c() {
    			if (if_block0) if_block0.c();
    			t0 = space();
    			p0 = element("p");
    			if (if_block1) if_block1.c();
    			t1 = space();
    			if (if_block2) if_block2.c();
    			t2 = space();
    			p1 = element("p");
    			if (if_block3) if_block3.c();
    			t3 = space();
    			if (if_block4) if_block4.c();
    		},
    		m(target, anchor) {
    			if (if_block0) if_block0.m(target, anchor);
    			insert(target, t0, anchor);
    			insert(target, p0, anchor);
    			if (if_block1) if_block1.m(p0, null);
    			append(p0, t1);
    			if (if_block2) if_block2.m(p0, null);
    			insert(target, t2, anchor);
    			insert(target, p1, anchor);
    			if (if_block3) if_block3.m(p1, null);
    			append(p1, t3);
    			if (if_block4) if_block4.m(p1, null);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 1) show_if = !isEmpty_1(/*post*/ ctx[0].participants);

    			if (show_if) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);

    					if (dirty & /*post*/ 1) {
    						transition_in(if_block0, 1);
    					}
    				} else {
    					if_block0 = create_if_block_6$2(ctx);
    					if_block0.c();
    					transition_in(if_block0, 1);
    					if_block0.m(t0.parentNode, t0);
    				}
    			} else if (if_block0) {
    				if_block0.d(1);
    				if_block0 = null;
    			}

    			if (/*$isEnglish*/ ctx[8]) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);
    				} else {
    					if_block1 = create_if_block_5$3(ctx);
    					if_block1.c();
    					if_block1.m(p0, t1);
    				}
    			} else if (if_block1) {
    				if_block1.d(1);
    				if_block1 = null;
    			}

    			if (/*$isArabic*/ ctx[9]) {
    				if (if_block2) {
    					if_block2.p(ctx, dirty);
    				} else {
    					if_block2 = create_if_block_4$3(ctx);
    					if_block2.c();
    					if_block2.m(p0, null);
    				}
    			} else if (if_block2) {
    				if_block2.d(1);
    				if_block2 = null;
    			}

    			if (/*$isEnglish*/ ctx[8]) {
    				if (if_block3) {
    					if_block3.p(ctx, dirty);
    				} else {
    					if_block3 = create_if_block_3$4(ctx);
    					if_block3.c();
    					if_block3.m(p1, t3);
    				}
    			} else if (if_block3) {
    				if_block3.d(1);
    				if_block3 = null;
    			}

    			if (/*$isArabic*/ ctx[9] && /*post*/ ctx[0].ar_linkFile) {
    				if (if_block4) {
    					if_block4.p(ctx, dirty);
    				} else {
    					if_block4 = create_if_block_2$4(ctx);
    					if_block4.c();
    					if_block4.m(p1, null);
    				}
    			} else if (if_block4) {
    				if_block4.d(1);
    				if_block4 = null;
    			}
    		},
    		i(local) {
    			transition_in(if_block0);

    			if (!p0_intro) {
    				add_render_callback(() => {
    					p0_intro = create_in_transition(p0, fly, { duration: 150, delay: 100, y: 10 });
    					p0_intro.start();
    				});
    			}

    			if (!p1_intro) {
    				add_render_callback(() => {
    					p1_intro = create_in_transition(p1, fly, { duration: 150, delay: 200, y: 10 });
    					p1_intro.start();
    				});
    			}
    		},
    		o: noop$1,
    		d(detaching) {
    			if (if_block0) if_block0.d(detaching);
    			if (detaching) detach(t0);
    			if (detaching) detach(p0);
    			if (if_block1) if_block1.d();
    			if (if_block2) if_block2.d();
    			if (detaching) detach(t2);
    			if (detaching) detach(p1);
    			if (if_block3) if_block3.d();
    			if (if_block4) if_block4.d();
    		}
    	};
    }

    // (430:12) {#if !isEmpty(post.participants)}
    function create_if_block_6$2(ctx) {
    	let p;
    	let a;
    	let t_value = get_1(/*post*/ ctx[0], 'participants[0].en_title', '') + "";
    	let t;
    	let a_href_value;
    	let p_intro;

    	return {
    		c() {
    			p = element("p");
    			a = element("a");
    			t = text(t_value);
    			attr(a, "href", a_href_value = "/" + /*$languagePrefix*/ ctx[10] + "/participant/" + get_1(/*post*/ ctx[0], 'participants[0].slug', ''));
    			attr(a, "class", "author");
    		},
    		m(target, anchor) {
    			insert(target, p, anchor);
    			append(p, a);
    			append(a, t);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 1 && t_value !== (t_value = get_1(/*post*/ ctx[0], 'participants[0].en_title', '') + "")) set_data(t, t_value);

    			if (dirty & /*$languagePrefix, post*/ 1025 && a_href_value !== (a_href_value = "/" + /*$languagePrefix*/ ctx[10] + "/participant/" + get_1(/*post*/ ctx[0], 'participants[0].slug', ''))) {
    				attr(a, "href", a_href_value);
    			}
    		},
    		i(local) {
    			if (!p_intro) {
    				add_render_callback(() => {
    					p_intro = create_in_transition(p, fly, { duration: 150, y: 10 });
    					p_intro.start();
    				});
    			}
    		},
    		o: noop$1,
    		d(detaching) {
    			if (detaching) detach(p);
    		}
    	};
    }

    // (440:14) {#if $isEnglish}
    function create_if_block_5$3(ctx) {
    	let t_value = /*post*/ ctx[0].en_title + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 1 && t_value !== (t_value = /*post*/ ctx[0].en_title + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (441:14) {#if $isArabic}
    function create_if_block_4$3(ctx) {
    	let t_value = /*post*/ ctx[0].ar_title + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 1 && t_value !== (t_value = /*post*/ ctx[0].ar_title + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (445:14) {#if $isEnglish}
    function create_if_block_3$4(ctx) {
    	let a;
    	let t0;
    	let t1_value = /*post*/ ctx[0].publisherName + "";
    	let t1;
    	let a_href_value;

    	return {
    		c() {
    			a = element("a");
    			t0 = text("Read on ");
    			t1 = text(t1_value);
    			attr(a, "href", a_href_value = /*post*/ ctx[0].link);
    			attr(a, "target", "_blank");
    			attr(a, "class", "external-link svelte-7v1ssr");
    		},
    		m(target, anchor) {
    			insert(target, a, anchor);
    			append(a, t0);
    			append(a, t1);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 1 && t1_value !== (t1_value = /*post*/ ctx[0].publisherName + "")) set_data(t1, t1_value);

    			if (dirty & /*post*/ 1 && a_href_value !== (a_href_value = /*post*/ ctx[0].link)) {
    				attr(a, "href", a_href_value);
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(a);
    		}
    	};
    }

    // (450:14) {#if $isArabic && post.ar_linkFile}
    function create_if_block_2$4(ctx) {
    	let a;
    	let t_value = /*post*/ ctx[0].ar_linkText + "";
    	let t;
    	let a_href_value;

    	return {
    		c() {
    			a = element("a");
    			t = text(t_value);
    			attr(a, "href", a_href_value = "" + (/*post*/ ctx[0].ar_linkFile + "?dl="));
    			attr(a, "class", "external-link svelte-7v1ssr");
    			attr(a, "download", "");
    		},
    		m(target, anchor) {
    			insert(target, a, anchor);
    			append(a, t);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 1 && t_value !== (t_value = /*post*/ ctx[0].ar_linkText + "")) set_data(t, t_value);

    			if (dirty & /*post*/ 1 && a_href_value !== (a_href_value = "" + (/*post*/ ctx[0].ar_linkFile + "?dl="))) {
    				attr(a, "href", a_href_value);
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(a);
    		}
    	};
    }

    // (383:0) <Router>
    function create_default_slot$5(ctx) {
    	let div;
    	let current_block_type_index;
    	let if_block;
    	let div_class_value;
    	let current;
    	let mounted;
    	let dispose;
    	const if_block_creators = [create_if_block$b, create_else_block_1$1];
    	const if_blocks = [];

    	function select_block_type(ctx, dirty) {
    		if (/*post*/ ctx[0].category === 'writing' && !/*post*/ ctx[0].isSticky) return 0;
    		return 1;
    	}

    	current_block_type_index = select_block_type(ctx);
    	if_block = if_blocks[current_block_type_index] = if_block_creators[current_block_type_index](ctx);

    	return {
    		c() {
    			div = element("div");
    			if_block.c();
    			attr(div, "class", div_class_value = "tile width-" + /*width*/ ctx[1] + " order-" + /*order*/ ctx[2] + " " + /*color*/ ctx[4] + " svelte-7v1ssr");
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);
    			if_blocks[current_block_type_index].m(div, null);
    			/*div_binding*/ ctx[18](div);
    			current = true;

    			if (!mounted) {
    				dispose = action_destroyer(links.call(null, div));
    				mounted = true;
    			}
    		},
    		p(ctx, dirty) {
    			let previous_block_index = current_block_type_index;
    			current_block_type_index = select_block_type(ctx);

    			if (current_block_type_index === previous_block_index) {
    				if_blocks[current_block_type_index].p(ctx, dirty);
    			} else {
    				group_outros();

    				transition_out(if_blocks[previous_block_index], 1, 1, () => {
    					if_blocks[previous_block_index] = null;
    				});

    				check_outros();
    				if_block = if_blocks[current_block_type_index];

    				if (!if_block) {
    					if_block = if_blocks[current_block_type_index] = if_block_creators[current_block_type_index](ctx);
    					if_block.c();
    				} else {
    					if_block.p(ctx, dirty);
    				}

    				transition_in(if_block, 1);
    				if_block.m(div, null);
    			}

    			if (!current || dirty & /*width, order, color*/ 22 && div_class_value !== (div_class_value = "tile width-" + /*width*/ ctx[1] + " order-" + /*order*/ ctx[2] + " " + /*color*/ ctx[4] + " svelte-7v1ssr")) {
    				attr(div, "class", div_class_value);
    			}
    		},
    		i(local) {
    			if (current) return;
    			transition_in(if_block);
    			current = true;
    		},
    		o(local) {
    			transition_out(if_block);
    			current = false;
    		},
    		d(detaching) {
    			if (detaching) detach(div);
    			if_blocks[current_block_type_index].d();
    			/*div_binding*/ ctx[18](null);
    			mounted = false;
    			dispose();
    		}
    	};
    }

    function create_fragment$d(ctx) {
    	let router;
    	let current;

    	router = new Router({
    			props: {
    				$$slots: { default: [create_default_slot$5] },
    				$$scope: { ctx }
    			}
    		});

    	return {
    		c() {
    			create_component(router.$$.fragment);
    		},
    		m(target, anchor) {
    			mount_component(router, target, anchor);
    			current = true;
    		},
    		p(ctx, [dirty]) {
    			const router_changes = {};

    			if (dirty & /*$$scope, width, order, color, tileEl, linkOutActive, post, $isArabic, $isEnglish, $languagePrefix, loaded, inView*/ 2099199) {
    				router_changes.$$scope = { dirty, ctx };
    			}

    			router.$set(router_changes);
    		},
    		i(local) {
    			if (current) return;
    			transition_in(router.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(router.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			destroy_component(router, detaching);
    		}
    	};
    }

    function instance$c($$self, $$props, $$invalidate) {
    	let $categoryList;
    	let $isEnglish;
    	let $isArabic;
    	let $languagePrefix;
    	component_subscribe($$self, categoryList, $$value => $$invalidate(12, $categoryList = $$value));
    	component_subscribe($$self, isEnglish, $$value => $$invalidate(8, $isEnglish = $$value));
    	component_subscribe($$self, isArabic, $$value => $$invalidate(9, $isArabic = $$value));
    	component_subscribe($$self, languagePrefix, $$value => $$invalidate(10, $languagePrefix = $$value));
    	let { post = {} } = $$props;
    	let { width = 20 } = $$props;
    	let { order = 0 } = $$props;

    	// *** DOM REFERENCES
    	let tileEl = {};

    	// ** VARIABLES
    	let color = "";

    	let loaded = false;
    	let linkOutActive = false;
    	const imgWidth = width >= 25 ? 600 : 400;
    	let inView = false;

    	// <<< RE-USE
    	const observer = new IntersectionObserver(entries => {
    			entries.forEach(entry => {
    				if (entry.intersectionRatio > 0) {
    					$$invalidate(7, inView = true);
    					observer.disconnect();
    				}
    			});
    		},
    	{ threshold: 0.05 });

    	if (!post.mainImage) loaded = true;

    	onMount(async () => {
    		observer.observe(tileEl);
    	});

    	const load_handler = () => $$invalidate(5, loaded = true);
    	const load_handler_1 = () => $$invalidate(5, loaded = true);
    	const click_handler = e => $$invalidate(6, linkOutActive = !linkOutActive);
    	const load_handler_2 = () => $$invalidate(5, loaded = true);
    	const load_handler_3 = () => $$invalidate(5, loaded = true);

    	function div_binding($$value) {
    		binding_callbacks[$$value ? 'unshift' : 'push'](() => {
    			tileEl = $$value;
    			$$invalidate(3, tileEl);
    		});
    	}

    	$$self.$$set = $$props => {
    		if ('post' in $$props) $$invalidate(0, post = $$props.post);
    		if ('width' in $$props) $$invalidate(1, width = $$props.width);
    		if ('order' in $$props) $$invalidate(2, order = $$props.order);
    	};

    	$$self.$$.update = () => {
    		if ($$self.$$.dirty & /*post, $categoryList*/ 4097) {
    			// >>> RE-USE
    			{
    				if (post.category) {
    					let matchingCategory = $categoryList.find(cat => cat.categorySlug === kebabCase_1(post.category));

    					$$invalidate(4, color = matchingCategory
    					? matchingCategory.color
    					: "rfgen-white");
    				}
    			}
    		}
    	};

    	return [
    		post,
    		width,
    		order,
    		tileEl,
    		color,
    		loaded,
    		linkOutActive,
    		inView,
    		$isEnglish,
    		$isArabic,
    		$languagePrefix,
    		imgWidth,
    		$categoryList,
    		load_handler,
    		load_handler_1,
    		click_handler,
    		load_handler_2,
    		load_handler_3,
    		div_binding
    	];
    }

    class Tile extends SvelteComponent {
    	constructor(options) {
    		super();
    		init(this, options, instance$c, create_fragment$d, safe_not_equal, { post: 0, width: 1, order: 2 });
    	}
    }

    /* src\Components\IntroTile.svelte generated by Svelte v3.58.0 */

    function create_if_block_1$8(ctx) {
    	let span;
    	let t_value = toPlainText(/*post*/ ctx[0].en_content) + "";
    	let t;

    	return {
    		c() {
    			span = element("span");
    			t = text(t_value);
    			attr(span, "class", "svelte-1f1jado");
    		},
    		m(target, anchor) {
    			insert(target, span, anchor);
    			append(span, t);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 1 && t_value !== (t_value = toPlainText(/*post*/ ctx[0].en_content) + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(span);
    		}
    	};
    }

    // (239:8) {#if $isArabic}
    function create_if_block$a(ctx) {
    	let span;
    	let t_value = toPlainText(/*post*/ ctx[0].ar_content) + "";
    	let t;

    	return {
    		c() {
    			span = element("span");
    			t = text(t_value);
    			attr(span, "class", "svelte-1f1jado");
    		},
    		m(target, anchor) {
    			insert(target, span, anchor);
    			append(span, t);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 1 && t_value !== (t_value = toPlainText(/*post*/ ctx[0].ar_content) + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(span);
    		}
    	};
    }

    // (232:0) <Router>
    function create_default_slot$4(ctx) {
    	let div1;
    	let a;
    	let div0;
    	let t;
    	let div0_class_value;
    	let a_href_value;
    	let mounted;
    	let dispose;
    	let if_block0 = /*$isEnglish*/ ctx[3] && create_if_block_1$8(ctx);
    	let if_block1 = /*$isArabic*/ ctx[4] && create_if_block$a(ctx);

    	return {
    		c() {
    			div1 = element("div");
    			a = element("a");
    			div0 = element("div");
    			if (if_block0) if_block0.c();
    			t = space();
    			if (if_block1) if_block1.c();
    			attr(div0, "class", div0_class_value = "intro-tile-bar " + /*color*/ ctx[1] + " svelte-1f1jado");
    			attr(a, "href", a_href_value = "/" + /*$languagePrefix*/ ctx[2] + "/introduction/" + /*post*/ ctx[0].slug);
    			attr(div1, "class", "intro-tile svelte-1f1jado");
    		},
    		m(target, anchor) {
    			insert(target, div1, anchor);
    			append(div1, a);
    			append(a, div0);
    			if (if_block0) if_block0.m(div0, null);
    			append(div0, t);
    			if (if_block1) if_block1.m(div0, null);

    			if (!mounted) {
    				dispose = action_destroyer(links.call(null, div1));
    				mounted = true;
    			}
    		},
    		p(ctx, dirty) {
    			if (/*$isEnglish*/ ctx[3]) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);
    				} else {
    					if_block0 = create_if_block_1$8(ctx);
    					if_block0.c();
    					if_block0.m(div0, t);
    				}
    			} else if (if_block0) {
    				if_block0.d(1);
    				if_block0 = null;
    			}

    			if (/*$isArabic*/ ctx[4]) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);
    				} else {
    					if_block1 = create_if_block$a(ctx);
    					if_block1.c();
    					if_block1.m(div0, null);
    				}
    			} else if (if_block1) {
    				if_block1.d(1);
    				if_block1 = null;
    			}

    			if (dirty & /*color*/ 2 && div0_class_value !== (div0_class_value = "intro-tile-bar " + /*color*/ ctx[1] + " svelte-1f1jado")) {
    				attr(div0, "class", div0_class_value);
    			}

    			if (dirty & /*$languagePrefix, post*/ 5 && a_href_value !== (a_href_value = "/" + /*$languagePrefix*/ ctx[2] + "/introduction/" + /*post*/ ctx[0].slug)) {
    				attr(a, "href", a_href_value);
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(div1);
    			if (if_block0) if_block0.d();
    			if (if_block1) if_block1.d();
    			mounted = false;
    			dispose();
    		}
    	};
    }

    function create_fragment$c(ctx) {
    	let router;
    	let current;

    	router = new Router({
    			props: {
    				$$slots: { default: [create_default_slot$4] },
    				$$scope: { ctx }
    			}
    		});

    	return {
    		c() {
    			create_component(router.$$.fragment);
    		},
    		m(target, anchor) {
    			mount_component(router, target, anchor);
    			current = true;
    		},
    		p(ctx, [dirty]) {
    			const router_changes = {};

    			if (dirty & /*$$scope, $languagePrefix, post, color, $isArabic, $isEnglish*/ 95) {
    				router_changes.$$scope = { dirty, ctx };
    			}

    			router.$set(router_changes);
    		},
    		i(local) {
    			if (current) return;
    			transition_in(router.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(router.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			destroy_component(router, detaching);
    		}
    	};
    }

    function instance$b($$self, $$props, $$invalidate) {
    	let $categoryList;
    	let $languagePrefix;
    	let $isEnglish;
    	let $isArabic;
    	component_subscribe($$self, categoryList, $$value => $$invalidate(5, $categoryList = $$value));
    	component_subscribe($$self, languagePrefix, $$value => $$invalidate(2, $languagePrefix = $$value));
    	component_subscribe($$self, isEnglish, $$value => $$invalidate(3, $isEnglish = $$value));
    	component_subscribe($$self, isArabic, $$value => $$invalidate(4, $isArabic = $$value));
    	let { post = {} } = $$props;

    	// ** VARIABLES
    	let color = "";

    	$$self.$$set = $$props => {
    		if ('post' in $$props) $$invalidate(0, post = $$props.post);
    	};

    	$$self.$$.update = () => {
    		if ($$self.$$.dirty & /*post, $categoryList*/ 33) {
    			// >>> RE-USE
    			{
    				if (post.category) {
    					let matchingCategory = $categoryList.find(cat => cat.categorySlug === kebabCase_1(post.slug));

    					$$invalidate(1, color = matchingCategory
    					? matchingCategory.color
    					: "rfgen-white");
    				}
    			}
    		}
    	};

    	return [post, color, $languagePrefix, $isEnglish, $isArabic, $categoryList];
    }

    class IntroTile extends SvelteComponent {
    	constructor(options) {
    		super();
    		init(this, options, instance$b, create_fragment$c, safe_not_equal, { post: 0 });
    	}
    }

    /* src\Components\Row.svelte generated by Svelte v3.58.0 */

    function get_each_context_1$2(ctx, list, i) {
    	const child_ctx = ctx.slice();
    	child_ctx[7] = list[i];
    	child_ctx[9] = i;
    	return child_ctx;
    }

    function get_each_context$4(ctx, list, i) {
    	const child_ctx = ctx.slice();
    	child_ctx[7] = list[i];
    	child_ctx[9] = i;
    	return child_ctx;
    }

    // (193:2) {:else}
    function create_else_block_1(ctx) {
    	let each_blocks = [];
    	let each_1_lookup = new Map();
    	let each_1_anchor;
    	let current;
    	let each_value_1 = /*row*/ ctx[0];
    	const get_key = ctx => /*post*/ ctx[7].slug;

    	for (let i = 0; i < each_value_1.length; i += 1) {
    		let child_ctx = get_each_context_1$2(ctx, each_value_1, i);
    		let key = get_key(child_ctx);
    		each_1_lookup.set(key, each_blocks[i] = create_each_block_1$2(key, child_ctx));
    	}

    	return {
    		c() {
    			for (let i = 0; i < each_blocks.length; i += 1) {
    				each_blocks[i].c();
    			}

    			each_1_anchor = empty();
    		},
    		m(target, anchor) {
    			for (let i = 0; i < each_blocks.length; i += 1) {
    				if (each_blocks[i]) {
    					each_blocks[i].m(target, anchor);
    				}
    			}

    			insert(target, each_1_anchor, anchor);
    			current = true;
    		},
    		p(ctx, dirty) {
    			if (dirty & /*row, tileWidths*/ 5) {
    				each_value_1 = /*row*/ ctx[0];
    				group_outros();
    				each_blocks = update_keyed_each(each_blocks, dirty, get_key, 1, ctx, each_value_1, each_1_lookup, each_1_anchor.parentNode, outro_and_destroy_block, create_each_block_1$2, each_1_anchor, get_each_context_1$2);
    				check_outros();
    			}
    		},
    		i(local) {
    			if (current) return;

    			for (let i = 0; i < each_value_1.length; i += 1) {
    				transition_in(each_blocks[i]);
    			}

    			current = true;
    		},
    		o(local) {
    			for (let i = 0; i < each_blocks.length; i += 1) {
    				transition_out(each_blocks[i]);
    			}

    			current = false;
    		},
    		d(detaching) {
    			for (let i = 0; i < each_blocks.length; i += 1) {
    				each_blocks[i].d(detaching);
    			}

    			if (detaching) detach(each_1_anchor);
    		}
    	};
    }

    // (185:2) {#if hasIntroText(row)}
    function create_if_block$9(ctx) {
    	let each_blocks = [];
    	let each_1_lookup = new Map();
    	let each_1_anchor;
    	let current;
    	let each_value = /*row*/ ctx[0];
    	const get_key = ctx => /*post*/ ctx[7].slug;

    	for (let i = 0; i < each_value.length; i += 1) {
    		let child_ctx = get_each_context$4(ctx, each_value, i);
    		let key = get_key(child_ctx);
    		each_1_lookup.set(key, each_blocks[i] = create_each_block$4(key, child_ctx));
    	}

    	return {
    		c() {
    			for (let i = 0; i < each_blocks.length; i += 1) {
    				each_blocks[i].c();
    			}

    			each_1_anchor = empty();
    		},
    		m(target, anchor) {
    			for (let i = 0; i < each_blocks.length; i += 1) {
    				if (each_blocks[i]) {
    					each_blocks[i].m(target, anchor);
    				}
    			}

    			insert(target, each_1_anchor, anchor);
    			current = true;
    		},
    		p(ctx, dirty) {
    			if (dirty & /*row, introRowTileWidths*/ 9) {
    				each_value = /*row*/ ctx[0];
    				group_outros();
    				each_blocks = update_keyed_each(each_blocks, dirty, get_key, 1, ctx, each_value, each_1_lookup, each_1_anchor.parentNode, outro_and_destroy_block, create_each_block$4, each_1_anchor, get_each_context$4);
    				check_outros();
    			}
    		},
    		i(local) {
    			if (current) return;

    			for (let i = 0; i < each_value.length; i += 1) {
    				transition_in(each_blocks[i]);
    			}

    			current = true;
    		},
    		o(local) {
    			for (let i = 0; i < each_blocks.length; i += 1) {
    				transition_out(each_blocks[i]);
    			}

    			current = false;
    		},
    		d(detaching) {
    			for (let i = 0; i < each_blocks.length; i += 1) {
    				each_blocks[i].d(detaching);
    			}

    			if (detaching) detach(each_1_anchor);
    		}
    	};
    }

    // (194:4) {#each row as post, i (post.slug)}
    function create_each_block_1$2(key_1, ctx) {
    	let first;
    	let tile;
    	let current;

    	tile = new Tile({
    			props: {
    				post: /*post*/ ctx[7],
    				width: /*tileWidths*/ ctx[2][/*i*/ ctx[9]],
    				order: /*i*/ ctx[9]
    			}
    		});

    	return {
    		key: key_1,
    		first: null,
    		c() {
    			first = empty();
    			create_component(tile.$$.fragment);
    			this.first = first;
    		},
    		m(target, anchor) {
    			insert(target, first, anchor);
    			mount_component(tile, target, anchor);
    			current = true;
    		},
    		p(new_ctx, dirty) {
    			ctx = new_ctx;
    			const tile_changes = {};
    			if (dirty & /*row*/ 1) tile_changes.post = /*post*/ ctx[7];
    			if (dirty & /*row*/ 1) tile_changes.width = /*tileWidths*/ ctx[2][/*i*/ ctx[9]];
    			if (dirty & /*row*/ 1) tile_changes.order = /*i*/ ctx[9];
    			tile.$set(tile_changes);
    		},
    		i(local) {
    			if (current) return;
    			transition_in(tile.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(tile.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			if (detaching) detach(first);
    			destroy_component(tile, detaching);
    		}
    	};
    }

    // (189:6) {:else}
    function create_else_block$4(ctx) {
    	let tile;
    	let current;

    	tile = new Tile({
    			props: {
    				post: /*post*/ ctx[7],
    				width: /*introRowTileWidths*/ ctx[3][/*i*/ ctx[9] - 1],
    				order: /*i*/ ctx[9]
    			}
    		});

    	return {
    		c() {
    			create_component(tile.$$.fragment);
    		},
    		m(target, anchor) {
    			mount_component(tile, target, anchor);
    			current = true;
    		},
    		p(ctx, dirty) {
    			const tile_changes = {};
    			if (dirty & /*row*/ 1) tile_changes.post = /*post*/ ctx[7];
    			if (dirty & /*row*/ 1) tile_changes.width = /*introRowTileWidths*/ ctx[3][/*i*/ ctx[9] - 1];
    			if (dirty & /*row*/ 1) tile_changes.order = /*i*/ ctx[9];
    			tile.$set(tile_changes);
    		},
    		i(local) {
    			if (current) return;
    			transition_in(tile.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(tile.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			destroy_component(tile, detaching);
    		}
    	};
    }

    // (187:6) {#if post.category === 'categoryIntroduction'}
    function create_if_block_1$7(ctx) {
    	let introtile;
    	let current;
    	introtile = new IntroTile({ props: { post: /*post*/ ctx[7] } });

    	return {
    		c() {
    			create_component(introtile.$$.fragment);
    		},
    		m(target, anchor) {
    			mount_component(introtile, target, anchor);
    			current = true;
    		},
    		p(ctx, dirty) {
    			const introtile_changes = {};
    			if (dirty & /*row*/ 1) introtile_changes.post = /*post*/ ctx[7];
    			introtile.$set(introtile_changes);
    		},
    		i(local) {
    			if (current) return;
    			transition_in(introtile.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(introtile.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			destroy_component(introtile, detaching);
    		}
    	};
    }

    // (186:4) {#each row as post, i (post.slug)}
    function create_each_block$4(key_1, ctx) {
    	let first;
    	let current_block_type_index;
    	let if_block;
    	let if_block_anchor;
    	let current;
    	const if_block_creators = [create_if_block_1$7, create_else_block$4];
    	const if_blocks = [];

    	function select_block_type_1(ctx, dirty) {
    		if (/*post*/ ctx[7].category === 'categoryIntroduction') return 0;
    		return 1;
    	}

    	current_block_type_index = select_block_type_1(ctx);
    	if_block = if_blocks[current_block_type_index] = if_block_creators[current_block_type_index](ctx);

    	return {
    		key: key_1,
    		first: null,
    		c() {
    			first = empty();
    			if_block.c();
    			if_block_anchor = empty();
    			this.first = first;
    		},
    		m(target, anchor) {
    			insert(target, first, anchor);
    			if_blocks[current_block_type_index].m(target, anchor);
    			insert(target, if_block_anchor, anchor);
    			current = true;
    		},
    		p(new_ctx, dirty) {
    			ctx = new_ctx;
    			let previous_block_index = current_block_type_index;
    			current_block_type_index = select_block_type_1(ctx);

    			if (current_block_type_index === previous_block_index) {
    				if_blocks[current_block_type_index].p(ctx, dirty);
    			} else {
    				group_outros();

    				transition_out(if_blocks[previous_block_index], 1, 1, () => {
    					if_blocks[previous_block_index] = null;
    				});

    				check_outros();
    				if_block = if_blocks[current_block_type_index];

    				if (!if_block) {
    					if_block = if_blocks[current_block_type_index] = if_block_creators[current_block_type_index](ctx);
    					if_block.c();
    				} else {
    					if_block.p(ctx, dirty);
    				}

    				transition_in(if_block, 1);
    				if_block.m(if_block_anchor.parentNode, if_block_anchor);
    			}
    		},
    		i(local) {
    			if (current) return;
    			transition_in(if_block);
    			current = true;
    		},
    		o(local) {
    			transition_out(if_block);
    			current = false;
    		},
    		d(detaching) {
    			if (detaching) detach(first);
    			if_blocks[current_block_type_index].d(detaching);
    			if (detaching) detach(if_block_anchor);
    		}
    	};
    }

    function create_fragment$b(ctx) {
    	let div;
    	let show_if;
    	let current_block_type_index;
    	let if_block;
    	let current;
    	const if_block_creators = [create_if_block$9, create_else_block_1];
    	const if_blocks = [];

    	function select_block_type(ctx, dirty) {
    		if (dirty & /*row*/ 1) show_if = null;
    		if (show_if == null) show_if = !!/*hasIntroText*/ ctx[1](/*row*/ ctx[0]);
    		if (show_if) return 0;
    		return 1;
    	}

    	current_block_type_index = select_block_type(ctx, -1);
    	if_block = if_blocks[current_block_type_index] = if_block_creators[current_block_type_index](ctx);

    	return {
    		c() {
    			div = element("div");
    			if_block.c();
    			attr(div, "class", "row svelte-1vbtcxr");
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);
    			if_blocks[current_block_type_index].m(div, null);
    			current = true;
    		},
    		p(ctx, [dirty]) {
    			let previous_block_index = current_block_type_index;
    			current_block_type_index = select_block_type(ctx, dirty);

    			if (current_block_type_index === previous_block_index) {
    				if_blocks[current_block_type_index].p(ctx, dirty);
    			} else {
    				group_outros();

    				transition_out(if_blocks[previous_block_index], 1, 1, () => {
    					if_blocks[previous_block_index] = null;
    				});

    				check_outros();
    				if_block = if_blocks[current_block_type_index];

    				if (!if_block) {
    					if_block = if_blocks[current_block_type_index] = if_block_creators[current_block_type_index](ctx);
    					if_block.c();
    				} else {
    					if_block.p(ctx, dirty);
    				}

    				transition_in(if_block, 1);
    				if_block.m(div, null);
    			}
    		},
    		i(local) {
    			if (current) return;
    			transition_in(if_block);
    			current = true;
    		},
    		o(local) {
    			transition_out(if_block);
    			current = false;
    		},
    		d(detaching) {
    			if (detaching) detach(div);
    			if_blocks[current_block_type_index].d();
    		}
    	};
    }

    function instance$a($$self, $$props, $$invalidate) {
    	let { row = [] } = $$props;

    	const layouts = [
    		[20, 20, 20, 20, 20],
    		[25, 25, 20, 15, 15],
    		[20, 20, 20, 15, 25],
    		[30, 20, 20, 15, 15],
    		[15, 15, 15, 20, 35],
    		[15, 15, 15, 15, 40]
    	];

    	const introRowLayouts = [[15, 15, 20, 20], [15, 15, 15, 25]];

    	const hasIntroText = row => {
    		return row.find(p => p.category === "categoryIntroduction");
    	};

    	const defaultLayout = layouts[0];

    	const tileWidths = row.length === 5
    	? shuffle_1(sample_1(layouts))
    	: defaultLayout;

    	const introRowTileWidths = shuffle_1(sample_1(introRowLayouts));

    	$$self.$$set = $$props => {
    		if ('row' in $$props) $$invalidate(0, row = $$props.row);
    	};

    	return [row, hasIntroText, tileWidths, introRowTileWidths];
    }

    class Row extends SvelteComponent {
    	constructor(options) {
    		super();
    		init(this, options, instance$a, create_fragment$b, safe_not_equal, { row: 0 });
    	}
    }

    /* src\Components\Satoshi.svelte generated by Svelte v3.58.0 */

    function create_if_block$8(ctx) {
    	let img;
    	let img_src_value;
    	let img_class_value;
    	let mounted;
    	let dispose;

    	return {
    		c() {
    			img = element("img");

    			if (!src_url_equal(img.src, img_src_value = /*tiled*/ ctx[0]
    			? urlFor(/*imageObject*/ ctx[6]).width(1400).height(440).quality(90).auto('format').url()
    			: urlFor(/*imageObject*/ ctx[6]).height(1400).width(1000).quality(90).auto('format').url())) attr(img, "src", img_src_value);

    			attr(img, "class", img_class_value = "satoshi-image " + /*imageHeight*/ ctx[2] + " " + /*imageWidth*/ ctx[3] + " " + /*imagePosition*/ ctx[4] + " svelte-1wp15gt");
    			attr(img, "alt", "Satoshi Fujiwara");
    			toggle_class(img, "loaded", /*loaded*/ ctx[7]);
    		},
    		m(target, anchor) {
    			insert(target, img, anchor);

    			if (!mounted) {
    				dispose = listen$1(img, "load", /*load_handler*/ ctx[10]);
    				mounted = true;
    			}
    		},
    		p(ctx, dirty) {
    			if (dirty & /*tiled, imageObject*/ 65 && !src_url_equal(img.src, img_src_value = /*tiled*/ ctx[0]
    			? urlFor(/*imageObject*/ ctx[6]).width(1400).height(440).quality(90).auto('format').url()
    			: urlFor(/*imageObject*/ ctx[6]).height(1400).width(1000).quality(90).auto('format').url())) {
    				attr(img, "src", img_src_value);
    			}

    			if (dirty & /*imageHeight, imageWidth, imagePosition*/ 28 && img_class_value !== (img_class_value = "satoshi-image " + /*imageHeight*/ ctx[2] + " " + /*imageWidth*/ ctx[3] + " " + /*imagePosition*/ ctx[4] + " svelte-1wp15gt")) {
    				attr(img, "class", img_class_value);
    			}

    			if (dirty & /*imageHeight, imageWidth, imagePosition, loaded*/ 156) {
    				toggle_class(img, "loaded", /*loaded*/ ctx[7]);
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(img);
    			mounted = false;
    			dispose();
    		}
    	};
    }

    function create_fragment$a(ctx) {
    	let div;
    	let if_block = /*inView*/ ctx[5] && create_if_block$8(ctx);

    	return {
    		c() {
    			div = element("div");
    			if (if_block) if_block.c();
    			attr(div, "class", "satoshi-container svelte-1wp15gt");
    			toggle_class(div, "tiled", /*tiled*/ ctx[0]);
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);
    			if (if_block) if_block.m(div, null);
    			/*div_binding*/ ctx[11](div);
    		},
    		p(ctx, [dirty]) {
    			if (/*inView*/ ctx[5]) {
    				if (if_block) {
    					if_block.p(ctx, dirty);
    				} else {
    					if_block = create_if_block$8(ctx);
    					if_block.c();
    					if_block.m(div, null);
    				}
    			} else if (if_block) {
    				if_block.d(1);
    				if_block = null;
    			}

    			if (dirty & /*tiled*/ 1) {
    				toggle_class(div, "tiled", /*tiled*/ ctx[0]);
    			}
    		},
    		i: noop$1,
    		o: noop$1,
    		d(detaching) {
    			if (detaching) detach(div);
    			if (if_block) if_block.d();
    			/*div_binding*/ ctx[11](null);
    		}
    	};
    }

    function instance$9($$self, $$props, $$invalidate) {
    	let $satoshiList;
    	component_subscribe($$self, satoshiList, $$value => $$invalidate(9, $satoshiList = $$value));
    	let satoshiEl = {};
    	let { tiled = false } = $$props;
    	let { satoshiIndex = 0 } = $$props;
    	let imageHeight = "height-100";
    	let imageWidth = "width-100";
    	let imagePosition = "position-right";
    	let inView = false;
    	let imageObject = {};

    	const observer = new IntersectionObserver(entries => {
    			entries.forEach(entry => {
    				if (entry.intersectionRatio > 0) {
    					$$invalidate(5, inView = true);
    					observer.disconnect();
    				}
    			});
    		},
    	{ threshold: 0.05 });

    	// ** VARIABLES
    	let loaded = false;

    	onMount(async () => {
    		observer.observe(satoshiEl);
    	});

    	const load_handler = () => $$invalidate(7, loaded = true);

    	function div_binding($$value) {
    		binding_callbacks[$$value ? 'unshift' : 'push'](() => {
    			satoshiEl = $$value;
    			$$invalidate(1, satoshiEl);
    		});
    	}

    	$$self.$$set = $$props => {
    		if ('tiled' in $$props) $$invalidate(0, tiled = $$props.tiled);
    		if ('satoshiIndex' in $$props) $$invalidate(8, satoshiIndex = $$props.satoshiIndex);
    	};

    	$$self.$$.update = () => {
    		if ($$self.$$.dirty & /*$satoshiList, satoshiIndex*/ 768) {
    			{
    				$$invalidate(6, imageObject = get_1($satoshiList[satoshiIndex], "mainImage", {}));
    			}
    		}
    	};

    	return [
    		tiled,
    		satoshiEl,
    		imageHeight,
    		imageWidth,
    		imagePosition,
    		inView,
    		imageObject,
    		loaded,
    		satoshiIndex,
    		$satoshiList,
    		load_handler,
    		div_binding
    	];
    }

    class Satoshi extends SvelteComponent {
    	constructor(options) {
    		super();
    		init(this, options, instance$9, create_fragment$a, safe_not_equal, { tiled: 0, satoshiIndex: 8 });
    	}
    }

    /* src\Views\TileView.svelte generated by Svelte v3.58.0 */

    function get_each_context$3(ctx, list, i) {
    	const child_ctx = ctx.slice();
    	child_ctx[14] = list[i];
    	child_ctx[16] = i;
    	return child_ctx;
    }

    // (360:2) {:catch error}
    function create_catch_block$4(ctx) {
    	let p;
    	let t_value = /*error*/ ctx[17].message + "";
    	let t;

    	return {
    		c() {
    			p = element("p");
    			t = text(t_value);
    			set_style(p, "color", "red");
    		},
    		m(target, anchor) {
    			insert(target, p, anchor);
    			append(p, t);
    		},
    		p: noop$1,
    		i: noop$1,
    		o: noop$1,
    		d(detaching) {
    			if (detaching) detach(p);
    		}
    	};
    }

    // (345:2) {:then posts}
    function create_then_block$4(ctx) {
    	let each_blocks = [];
    	let each_1_lookup = new Map();
    	let t;
    	let show_if = isEmpty_1(/*$activeNavigation*/ ctx[0]);
    	let if_block_anchor;
    	let current;
    	let each_value = /*splitRows*/ ctx[2](/*posts*/ ctx[3]);
    	const get_key = ctx => uniqueId_1('row_');

    	for (let i = 0; i < each_value.length; i += 1) {
    		let child_ctx = get_each_context$3(ctx, each_value, i);
    		let key = get_key();
    		each_1_lookup.set(key, each_blocks[i] = create_each_block$3(key, child_ctx));
    	}

    	let if_block = show_if && create_if_block$7();

    	return {
    		c() {
    			for (let i = 0; i < each_blocks.length; i += 1) {
    				each_blocks[i].c();
    			}

    			t = space();
    			if (if_block) if_block.c();
    			if_block_anchor = empty();
    		},
    		m(target, anchor) {
    			for (let i = 0; i < each_blocks.length; i += 1) {
    				if (each_blocks[i]) {
    					each_blocks[i].m(target, anchor);
    				}
    			}

    			insert(target, t, anchor);
    			if (if_block) if_block.m(target, anchor);
    			insert(target, if_block_anchor, anchor);
    			current = true;
    		},
    		p(ctx, dirty) {
    			if (dirty & /*sample, colorList, Math, splitRows, posts*/ 12) {
    				each_value = /*splitRows*/ ctx[2](/*posts*/ ctx[3]);
    				group_outros();
    				each_blocks = update_keyed_each(each_blocks, dirty, get_key, 1, ctx, each_value, each_1_lookup, t.parentNode, outro_and_destroy_block, create_each_block$3, t, get_each_context$3);
    				check_outros();
    			}

    			if (dirty & /*$activeNavigation*/ 1) show_if = isEmpty_1(/*$activeNavigation*/ ctx[0]);

    			if (show_if) {
    				if (if_block) {
    					if_block.p(ctx, dirty);

    					if (dirty & /*$activeNavigation*/ 1) {
    						transition_in(if_block, 1);
    					}
    				} else {
    					if_block = create_if_block$7();
    					if_block.c();
    					transition_in(if_block, 1);
    					if_block.m(if_block_anchor.parentNode, if_block_anchor);
    				}
    			} else if (if_block) {
    				group_outros();

    				transition_out(if_block, 1, 1, () => {
    					if_block = null;
    				});

    				check_outros();
    			}
    		},
    		i(local) {
    			if (current) return;

    			for (let i = 0; i < each_value.length; i += 1) {
    				transition_in(each_blocks[i]);
    			}

    			transition_in(if_block);
    			current = true;
    		},
    		o(local) {
    			for (let i = 0; i < each_blocks.length; i += 1) {
    				transition_out(each_blocks[i]);
    			}

    			transition_out(if_block);
    			current = false;
    		},
    		d(detaching) {
    			for (let i = 0; i < each_blocks.length; i += 1) {
    				each_blocks[i].d(detaching);
    			}

    			if (detaching) detach(t);
    			if (if_block) if_block.d(detaching);
    			if (detaching) detach(if_block_anchor);
    		}
    	};
    }

    // (351:6) {:else}
    function create_else_block$3(ctx) {
    	let row;
    	let current;
    	row = new Row({ props: { row: /*row*/ ctx[14] } });

    	return {
    		c() {
    			create_component(row.$$.fragment);
    		},
    		m(target, anchor) {
    			mount_component(row, target, anchor);
    			current = true;
    		},
    		p: noop$1,
    		i(local) {
    			if (current) return;
    			transition_in(row.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(row.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			destroy_component(row, detaching);
    		}
    	};
    }

    // (347:6) {#if row.satoshi}
    function create_if_block_1$6(ctx) {
    	let div;
    	let satoshi;
    	let current;

    	satoshi = new Satoshi({
    			props: {
    				tiled: true,
    				satoshiIndex: (Math.round(/*i*/ ctx[16] / 3) - 1) % 10
    			}
    		});

    	return {
    		c() {
    			div = element("div");
    			create_component(satoshi.$$.fragment);
    			attr(div, "class", "satoshi-strip " + sample_1(colorList) + " svelte-1y6qm1j");
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);
    			mount_component(satoshi, div, null);
    			current = true;
    		},
    		p: noop$1,
    		i(local) {
    			if (current) return;
    			transition_in(satoshi.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(satoshi.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			if (detaching) detach(div);
    			destroy_component(satoshi);
    		}
    	};
    }

    // (346:4) {#each splitRows(posts) as row, i (uniqueId('row_'))}
    function create_each_block$3(key_1, ctx) {
    	let first;
    	let current_block_type_index;
    	let if_block;
    	let if_block_anchor;
    	let current;
    	const if_block_creators = [create_if_block_1$6, create_else_block$3];
    	const if_blocks = [];

    	function select_block_type(ctx, dirty) {
    		if (/*row*/ ctx[14].satoshi) return 0;
    		return 1;
    	}

    	current_block_type_index = select_block_type(ctx);
    	if_block = if_blocks[current_block_type_index] = if_block_creators[current_block_type_index](ctx);

    	return {
    		key: key_1,
    		first: null,
    		c() {
    			first = empty();
    			if_block.c();
    			if_block_anchor = empty();
    			this.first = first;
    		},
    		m(target, anchor) {
    			insert(target, first, anchor);
    			if_blocks[current_block_type_index].m(target, anchor);
    			insert(target, if_block_anchor, anchor);
    			current = true;
    		},
    		p(new_ctx, dirty) {
    			ctx = new_ctx;
    			if_block.p(ctx, dirty);
    		},
    		i(local) {
    			if (current) return;
    			transition_in(if_block);
    			current = true;
    		},
    		o(local) {
    			transition_out(if_block);
    			current = false;
    		},
    		d(detaching) {
    			if (detaching) detach(first);
    			if_blocks[current_block_type_index].d(detaching);
    			if (detaching) detach(if_block_anchor);
    		}
    	};
    }

    // (355:4) {#if isEmpty($activeNavigation)}
    function create_if_block$7(ctx) {
    	let div;
    	let satoshi;
    	let current;
    	satoshi = new Satoshi({ props: { satoshiIndex: 5 } });

    	return {
    		c() {
    			div = element("div");
    			create_component(satoshi.$$.fragment);
    			attr(div, "class", "satoshi-strip " + sample_1(colorList) + " tall" + " svelte-1y6qm1j");
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);
    			mount_component(satoshi, div, null);
    			current = true;
    		},
    		p: noop$1,
    		i(local) {
    			if (current) return;
    			transition_in(satoshi.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(satoshi.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			if (detaching) detach(div);
    			destroy_component(satoshi);
    		}
    	};
    }

    // (343:16)       <div />    {:then posts}
    function create_pending_block$4(ctx) {
    	let div;

    	return {
    		c() {
    			div = element("div");
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);
    		},
    		p: noop$1,
    		i: noop$1,
    		o: noop$1,
    		d(detaching) {
    			if (detaching) detach(div);
    		}
    	};
    }

    function create_fragment$9(ctx) {
    	let metadata;
    	let t;
    	let div;
    	let current;
    	metadata = new MetaData({ props: { post: /*metaObject*/ ctx[1] } });

    	let info = {
    		ctx,
    		current: null,
    		token: null,
    		hasCatch: true,
    		pending: create_pending_block$4,
    		then: create_then_block$4,
    		catch: create_catch_block$4,
    		value: 3,
    		error: 17,
    		blocks: [,,,]
    	};

    	handle_promise(/*posts*/ ctx[3], info);

    	return {
    		c() {
    			create_component(metadata.$$.fragment);
    			t = space();
    			div = element("div");
    			info.block.c();
    			attr(div, "class", "tile-view svelte-1y6qm1j");
    		},
    		m(target, anchor) {
    			mount_component(metadata, target, anchor);
    			insert(target, t, anchor);
    			insert(target, div, anchor);
    			info.block.m(div, info.anchor = null);
    			info.mount = () => div;
    			info.anchor = null;
    			current = true;
    		},
    		p(new_ctx, [dirty]) {
    			ctx = new_ctx;
    			const metadata_changes = {};
    			if (dirty & /*metaObject*/ 2) metadata_changes.post = /*metaObject*/ ctx[1];
    			metadata.$set(metadata_changes);
    			update_await_block_branch(info, ctx, dirty);
    		},
    		i(local) {
    			if (current) return;
    			transition_in(metadata.$$.fragment, local);
    			transition_in(info.block);
    			current = true;
    		},
    		o(local) {
    			transition_out(metadata.$$.fragment, local);

    			for (let i = 0; i < 3; i += 1) {
    				const block = info.blocks[i];
    				transition_out(block);
    			}

    			current = false;
    		},
    		d(detaching) {
    			destroy_component(metadata, detaching);
    			if (detaching) detach(t);
    			if (detaching) detach(div);
    			info.block.d();
    			info.token = null;
    			info = null;
    		}
    	};
    }

    const query$5 = '*[_type in [ "project",  "discussion",  "performance",  "workingGroup",  "writing",  "participant",  "categoryIntroduction"]]{en_title, ar_title, "slug": slug.current, mainImage, "category": _type, en_content, ar_content, eventDate, customOrder, "en_title": en_name, "ar_title": ar_name, participants[]->{en_title, ar_title, "slug": slug.current}, link, publisherName, ar_linkText, "ar_linkFile": ar_linkFile.asset->url, isSticky }';

    function instance$8($$self, $$props, $$invalidate) {
    	let $categoryList;
    	let $activeNavigation;
    	component_subscribe($$self, categoryList, $$value => $$invalidate(7, $categoryList = $$value));
    	component_subscribe($$self, activeNavigation, $$value => $$invalidate(0, $activeNavigation = $$value));
    	let metaObject = { title: {} };
    	let { category = "" } = $$props;
    	let { categoryDisplayName = false } = $$props;
    	let { language = "" } = $$props;

    	// ** VARIABLES
    	let introductions = [];

    	// Set globals
    	globalLanguage.set(language === "ar" ? "arabic" : "english");

    	isTileView.set(true);

    	const filterPostsByCategory = posts => {
    		if (!$categoryList.find(c => c.categorySlug === category)) {
    			navigate("/");
    			return;
    		}

    		let filteredPosts = posts.filter(p => kebabCase_1(p.category) === category);

    		if (category === "discussion") {
    			filteredPosts = reverse_1(sortBy_1(filteredPosts, p => p.eventDate));
    		}

    		if (category === "working-group") {
    			filteredPosts = sortBy_1(filteredPosts, p => p.customOrder);
    		}

    		if (category === "writing") {
    			filteredPosts = sortBy_1(filteredPosts, p => !p.isSticky);
    		}

    		filteredPosts.unshift(introductions.find(p => p.slug === category));
    		return filteredPosts;
    	};

    	const splitRows = posts => {
    		if (category.length > 0) {
    			return chunk_1(filterPostsByCategory(posts), 5);
    		} else {
    			let chunked = chunk_1(posts, 5);
    			let spliced = [];

    			chunked.forEach((row, i) => {
    				if (i > 0 && i % 3 === 0) spliced.push({ satoshi: true });
    				spliced.push(row);
    			});

    			let lastItem = spliced.pop();

    			if (size_1(lastItem) < 5) {
    				spliced.push([...lastItem, ...take_1(spliced[0], 5 - size_1(lastItem))]);
    			} else {
    				spliced.push(lastItem);
    			}

    			return spliced;
    		}
    	};

    	// Predicates
    	const isCategoryIntroduction = p => p.category === "categoryIntroduction";

    	const intertwineCategories = posts => fp.compose(fp.compact, fp.flatten, fp.zipAll, fp.map(fp.shuffle), fp.values, fp.groupBy(p => p.category))(posts); // Remove undefined and null values, introduced when one category has few posts than another
    	// Remove wrapping array
    	// Intertwine the arrays
    	// Shuffle internal order of post-array
    	// Get values from grouped object => an aray for each
    	// Group by category
    	// fp.filter(hasImage) // Filter out posts without preview images (for now)

    	// >>> RE-USE
    	async function loadData(query, params) {
    		try {
    			const res = await client.fetch(query, params);
    			introductions = remove_1(res, isCategoryIntroduction);
    			return intertwineCategories(res);
    		} catch(err) {
    			
    		} // Sentry.captureException(err);
    	}

    	// <<< RE-USE
    	let posts = loadData(query$5, {});

    	// Generate sitemap.txt
    	// posts.then(res => {
    	//   console.log(
    	//     [
    	//       ...res.map(r => "https://rfgen.net/en/" + r.category + "/" + r.slug),
    	//       ...res.map(r => "https://rfgen.net/ar/" + r.category + "/" + r.slug)
    	//     ].join("\r\n")
    	//   );
    	// });
    	onMount(async () => {
    		window.scrollTo(0, 0);
    	});

    	onDestroy(() => isTileView.set(false));

    	$$self.$$set = $$props => {
    		if ('category' in $$props) $$invalidate(5, category = $$props.category);
    		if ('categoryDisplayName' in $$props) $$invalidate(4, categoryDisplayName = $$props.categoryDisplayName);
    		if ('language' in $$props) $$invalidate(6, language = $$props.language);
    	};

    	$$self.$$.update = () => {
    		if ($$self.$$.dirty & /*category*/ 32) {
    			{
    				activeNavigation.set(category ? category : "");
    				if (category) window.scrollTo(0, 0);
    			}
    		}

    		if ($$self.$$.dirty & /*$categoryList, $activeNavigation*/ 129) {
    			// >>> RE-USE
    			{
    				let categoryObject = $categoryList.find(c => c.categorySlug === $activeNavigation);

    				if (categoryObject) {
    					$$invalidate(4, categoryDisplayName = get_1(categoryObject, "nameDisplay.english", false));
    				}
    			}
    		}

    		if ($$self.$$.dirty & /*categoryDisplayName*/ 16) {
    			// <<< RE-USE
    			{
    				$$invalidate(1, metaObject.title.english = categoryDisplayName, metaObject);
    				$$invalidate(1, metaObject.title.arabic = categoryDisplayName, metaObject);
    			}
    		}
    	};

    	return [
    		$activeNavigation,
    		metaObject,
    		splitRows,
    		posts,
    		categoryDisplayName,
    		category,
    		language,
    		$categoryList
    	];
    }

    class TileView extends SvelteComponent {
    	constructor(options) {
    		super();

    		init(this, options, instance$8, create_fragment$9, safe_not_equal, {
    			category: 5,
    			categoryDisplayName: 4,
    			language: 6
    		});
    	}
    }

    /* src\Views\PageView.svelte generated by Svelte v3.58.0 */

    function get_each_context$2(ctx, list, i) {
    	const child_ctx = ctx.slice();
    	child_ctx[5] = list[i];
    	return child_ctx;
    }

    function get_each_context_1$1(ctx, list, i) {
    	const child_ctx = ctx.slice();
    	child_ctx[8] = list[i];
    	return child_ctx;
    }

    // (1:0) <script>    // # # # # # # # # # # # # #    //    //  PageView    //    // # # # # # # # # # # # # #      // *** IMPORT    import { onMount }
    function create_catch_block_1$2(ctx) {
    	return {
    		c: noop$1,
    		m: noop$1,
    		p: noop$1,
    		i: noop$1,
    		o: noop$1,
    		d: noop$1
    	};
    }

    // (281:23)     <MetaData post={page}
    function create_then_block_1$2(ctx) {
    	let metadata;
    	let current;
    	metadata = new MetaData({ props: { post: /*page*/ ctx[3] } });

    	return {
    		c() {
    			create_component(metadata.$$.fragment);
    		},
    		m(target, anchor) {
    			mount_component(metadata, target, anchor);
    			current = true;
    		},
    		p(ctx, dirty) {
    			const metadata_changes = {};
    			if (dirty & /*page*/ 8) metadata_changes.post = /*page*/ ctx[3];
    			metadata.$set(metadata_changes);
    		},
    		i(local) {
    			if (current) return;
    			transition_in(metadata.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(metadata.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			destroy_component(metadata, detaching);
    		}
    	};
    }

    // (1:0) <script>    // # # # # # # # # # # # # #    //    //  PageView    //    // # # # # # # # # # # # # #      // *** IMPORT    import { onMount }
    function create_pending_block_1$2(ctx) {
    	return {
    		c: noop$1,
    		m: noop$1,
    		p: noop$1,
    		i: noop$1,
    		o: noop$1,
    		d: noop$1
    	};
    }

    // (340:2) {:catch error}
    function create_catch_block$3(ctx) {
    	let p;
    	let t_value = /*error*/ ctx[11].message + "";
    	let t;

    	return {
    		c() {
    			p = element("p");
    			t = text(t_value);
    			set_style(p, "color", "red");
    		},
    		m(target, anchor) {
    			insert(target, p, anchor);
    			append(p, t);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*page*/ 8 && t_value !== (t_value = /*error*/ ctx[11].message + "")) set_data(t, t_value);
    		},
    		i: noop$1,
    		o: noop$1,
    		d(detaching) {
    			if (detaching) detach(p);
    		}
    	};
    }

    // (288:2) {:then page}
    function create_then_block$3(ctx) {
    	let div0;
    	let satoshi;
    	let t;
    	let div2;
    	let div1;
    	let div2_intro;
    	let current;

    	satoshi = new Satoshi({
    			props: {
    				satoshiIndex: /*page*/ ctx[3].satoshiIndex
    			}
    		});

    	function select_block_type(ctx, dirty) {
    		if (/*slug*/ ctx[0] === 'team') return create_if_block$6;
    		return create_else_block$2;
    	}

    	let current_block_type = select_block_type(ctx);
    	let if_block = current_block_type(ctx);

    	return {
    		c() {
    			div0 = element("div");
    			create_component(satoshi.$$.fragment);
    			t = space();
    			div2 = element("div");
    			div1 = element("div");
    			if_block.c();
    			attr(div0, "class", "page-view-image svelte-evc6nn");
    			toggle_class(div0, "arabic", /*$isArabic*/ ctx[1]);
    			attr(div1, "class", "page-view-text-inner svelte-evc6nn");
    			attr(div2, "class", "page-view-text svelte-evc6nn");
    		},
    		m(target, anchor) {
    			insert(target, div0, anchor);
    			mount_component(satoshi, div0, null);
    			insert(target, t, anchor);
    			insert(target, div2, anchor);
    			append(div2, div1);
    			if_block.m(div1, null);
    			current = true;
    		},
    		p(ctx, dirty) {
    			const satoshi_changes = {};
    			if (dirty & /*page*/ 8) satoshi_changes.satoshiIndex = /*page*/ ctx[3].satoshiIndex;
    			satoshi.$set(satoshi_changes);

    			if (!current || dirty & /*$isArabic*/ 2) {
    				toggle_class(div0, "arabic", /*$isArabic*/ ctx[1]);
    			}

    			if (current_block_type === (current_block_type = select_block_type(ctx)) && if_block) {
    				if_block.p(ctx, dirty);
    			} else {
    				if_block.d(1);
    				if_block = current_block_type(ctx);

    				if (if_block) {
    					if_block.c();
    					if_block.m(div1, null);
    				}
    			}
    		},
    		i(local) {
    			if (current) return;
    			transition_in(satoshi.$$.fragment, local);

    			if (!div2_intro) {
    				add_render_callback(() => {
    					div2_intro = create_in_transition(div2, fade, {});
    					div2_intro.start();
    				});
    			}

    			current = true;
    		},
    		o(local) {
    			transition_out(satoshi.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			if (detaching) detach(div0);
    			destroy_component(satoshi);
    			if (detaching) detach(t);
    			if (detaching) detach(div2);
    			if_block.d();
    		}
    	};
    }

    // (326:8) {:else}
    function create_else_block$2(ctx) {
    	let div;
    	let t0;
    	let t1;
    	let t2;
    	let if_block3_anchor;
    	let if_block0 = /*$isEnglish*/ ctx[2] && create_if_block_12$1(ctx);
    	let if_block1 = /*$isArabic*/ ctx[1] && create_if_block_11$1(ctx);
    	let if_block2 = /*$isEnglish*/ ctx[2] && create_if_block_10$1(ctx);
    	let if_block3 = /*$isArabic*/ ctx[1] && create_if_block_9$1(ctx);

    	return {
    		c() {
    			div = element("div");
    			if (if_block0) if_block0.c();
    			t0 = space();
    			if (if_block1) if_block1.c();
    			t1 = space();
    			if (if_block2) if_block2.c();
    			t2 = space();
    			if (if_block3) if_block3.c();
    			if_block3_anchor = empty();
    			attr(div, "class", "page-category svelte-evc6nn");
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);
    			if (if_block0) if_block0.m(div, null);
    			append(div, t0);
    			if (if_block1) if_block1.m(div, null);
    			insert(target, t1, anchor);
    			if (if_block2) if_block2.m(target, anchor);
    			insert(target, t2, anchor);
    			if (if_block3) if_block3.m(target, anchor);
    			insert(target, if_block3_anchor, anchor);
    		},
    		p(ctx, dirty) {
    			if (/*$isEnglish*/ ctx[2]) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);
    				} else {
    					if_block0 = create_if_block_12$1(ctx);
    					if_block0.c();
    					if_block0.m(div, t0);
    				}
    			} else if (if_block0) {
    				if_block0.d(1);
    				if_block0 = null;
    			}

    			if (/*$isArabic*/ ctx[1]) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);
    				} else {
    					if_block1 = create_if_block_11$1(ctx);
    					if_block1.c();
    					if_block1.m(div, null);
    				}
    			} else if (if_block1) {
    				if_block1.d(1);
    				if_block1 = null;
    			}

    			if (/*$isEnglish*/ ctx[2]) {
    				if (if_block2) {
    					if_block2.p(ctx, dirty);
    				} else {
    					if_block2 = create_if_block_10$1(ctx);
    					if_block2.c();
    					if_block2.m(t2.parentNode, t2);
    				}
    			} else if (if_block2) {
    				if_block2.d(1);
    				if_block2 = null;
    			}

    			if (/*$isArabic*/ ctx[1]) {
    				if (if_block3) {
    					if_block3.p(ctx, dirty);
    				} else {
    					if_block3 = create_if_block_9$1(ctx);
    					if_block3.c();
    					if_block3.m(if_block3_anchor.parentNode, if_block3_anchor);
    				}
    			} else if (if_block3) {
    				if_block3.d(1);
    				if_block3 = null;
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(div);
    			if (if_block0) if_block0.d();
    			if (if_block1) if_block1.d();
    			if (detaching) detach(t1);
    			if (if_block2) if_block2.d(detaching);
    			if (detaching) detach(t2);
    			if (if_block3) if_block3.d(detaching);
    			if (detaching) detach(if_block3_anchor);
    		}
    	};
    }

    // (294:8) {#if slug === 'team'}
    function create_if_block$6(ctx) {
    	let div1;
    	let div0;
    	let t1;
    	let t2;
    	let div3;
    	let div2;
    	let t4;
    	let each_value_1 = /*page*/ ctx[3].curatorialTeam;
    	let each_blocks_1 = [];

    	for (let i = 0; i < each_value_1.length; i += 1) {
    		each_blocks_1[i] = create_each_block_1$1(get_each_context_1$1(ctx, each_value_1, i));
    	}

    	let each_value = /*page*/ ctx[3].sharjahTeam;
    	let each_blocks = [];

    	for (let i = 0; i < each_value.length; i += 1) {
    		each_blocks[i] = create_each_block$2(get_each_context$2(ctx, each_value, i));
    	}

    	return {
    		c() {
    			div1 = element("div");
    			div0 = element("div");
    			div0.textContent = "Curatorial Team";
    			t1 = space();

    			for (let i = 0; i < each_blocks_1.length; i += 1) {
    				each_blocks_1[i].c();
    			}

    			t2 = space();
    			div3 = element("div");
    			div2 = element("div");
    			div2.textContent = "Sharjah Architecture Triennial Team";
    			t4 = space();

    			for (let i = 0; i < each_blocks.length; i += 1) {
    				each_blocks[i].c();
    			}

    			attr(div0, "class", "team-header svelte-evc6nn");
    			attr(div1, "class", "curatorial-team");
    			attr(div2, "class", "team-header svelte-evc6nn");
    			attr(div3, "class", "sharjah-team svelte-evc6nn");
    		},
    		m(target, anchor) {
    			insert(target, div1, anchor);
    			append(div1, div0);
    			append(div1, t1);

    			for (let i = 0; i < each_blocks_1.length; i += 1) {
    				if (each_blocks_1[i]) {
    					each_blocks_1[i].m(div1, null);
    				}
    			}

    			insert(target, t2, anchor);
    			insert(target, div3, anchor);
    			append(div3, div2);
    			append(div3, t4);

    			for (let i = 0; i < each_blocks.length; i += 1) {
    				if (each_blocks[i]) {
    					each_blocks[i].m(div3, null);
    				}
    			}
    		},
    		p(ctx, dirty) {
    			if (dirty & /*renderBlockText, page, $isArabic, $isEnglish*/ 14) {
    				each_value_1 = /*page*/ ctx[3].curatorialTeam;
    				let i;

    				for (i = 0; i < each_value_1.length; i += 1) {
    					const child_ctx = get_each_context_1$1(ctx, each_value_1, i);

    					if (each_blocks_1[i]) {
    						each_blocks_1[i].p(child_ctx, dirty);
    					} else {
    						each_blocks_1[i] = create_each_block_1$1(child_ctx);
    						each_blocks_1[i].c();
    						each_blocks_1[i].m(div1, null);
    					}
    				}

    				for (; i < each_blocks_1.length; i += 1) {
    					each_blocks_1[i].d(1);
    				}

    				each_blocks_1.length = each_value_1.length;
    			}

    			if (dirty & /*page, $isArabic, $isEnglish*/ 14) {
    				each_value = /*page*/ ctx[3].sharjahTeam;
    				let i;

    				for (i = 0; i < each_value.length; i += 1) {
    					const child_ctx = get_each_context$2(ctx, each_value, i);

    					if (each_blocks[i]) {
    						each_blocks[i].p(child_ctx, dirty);
    					} else {
    						each_blocks[i] = create_each_block$2(child_ctx);
    						each_blocks[i].c();
    						each_blocks[i].m(div3, null);
    					}
    				}

    				for (; i < each_blocks.length; i += 1) {
    					each_blocks[i].d(1);
    				}

    				each_blocks.length = each_value.length;
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(div1);
    			destroy_each(each_blocks_1, detaching);
    			if (detaching) detach(t2);
    			if (detaching) detach(div3);
    			destroy_each(each_blocks, detaching);
    		}
    	};
    }

    // (328:12) {#if $isEnglish}
    function create_if_block_12$1(ctx) {
    	let t_value = /*page*/ ctx[3].title.english + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*page*/ 8 && t_value !== (t_value = /*page*/ ctx[3].title.english + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (329:12) {#if $isArabic}
    function create_if_block_11$1(ctx) {
    	let t_value = /*page*/ ctx[3].title.arabic + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*page*/ 8 && t_value !== (t_value = /*page*/ ctx[3].title.arabic + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (331:10) {#if $isEnglish}
    function create_if_block_10$1(ctx) {
    	let html_tag;
    	let raw_value = renderBlockText(/*page*/ ctx[3].content.english) + "";
    	let html_anchor;

    	return {
    		c() {
    			html_tag = new HtmlTag(false);
    			html_anchor = empty();
    			html_tag.a = html_anchor;
    		},
    		m(target, anchor) {
    			html_tag.m(raw_value, target, anchor);
    			insert(target, html_anchor, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*page*/ 8 && raw_value !== (raw_value = renderBlockText(/*page*/ ctx[3].content.english) + "")) html_tag.p(raw_value);
    		},
    		d(detaching) {
    			if (detaching) detach(html_anchor);
    			if (detaching) html_tag.d();
    		}
    	};
    }

    // (334:10) {#if $isArabic}
    function create_if_block_9$1(ctx) {
    	let html_tag;
    	let raw_value = renderBlockText(/*page*/ ctx[3].content.arabic) + "";
    	let html_anchor;

    	return {
    		c() {
    			html_tag = new HtmlTag(false);
    			html_anchor = empty();
    			html_tag.a = html_anchor;
    		},
    		m(target, anchor) {
    			html_tag.m(raw_value, target, anchor);
    			insert(target, html_anchor, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*page*/ 8 && raw_value !== (raw_value = renderBlockText(/*page*/ ctx[3].content.arabic) + "")) html_tag.p(raw_value);
    		},
    		d(detaching) {
    			if (detaching) detach(html_anchor);
    			if (detaching) html_tag.d();
    		}
    	};
    }

    // (299:16) {#if $isEnglish}
    function create_if_block_8$1(ctx) {
    	let t_value = /*curatorialMember*/ ctx[8].en_name + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*page*/ 8 && t_value !== (t_value = /*curatorialMember*/ ctx[8].en_name + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (300:16) {#if $isArabic}
    function create_if_block_7$1(ctx) {
    	let t_value = /*curatorialMember*/ ctx[8].ar_name + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*page*/ 8 && t_value !== (t_value = /*curatorialMember*/ ctx[8].ar_name + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (303:16) {#if $isEnglish}
    function create_if_block_6$1(ctx) {
    	let html_tag;
    	let raw_value = renderBlockText(/*curatorialMember*/ ctx[8].en_bio) + "";
    	let html_anchor;

    	return {
    		c() {
    			html_tag = new HtmlTag(false);
    			html_anchor = empty();
    			html_tag.a = html_anchor;
    		},
    		m(target, anchor) {
    			html_tag.m(raw_value, target, anchor);
    			insert(target, html_anchor, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*page*/ 8 && raw_value !== (raw_value = renderBlockText(/*curatorialMember*/ ctx[8].en_bio) + "")) html_tag.p(raw_value);
    		},
    		d(detaching) {
    			if (detaching) detach(html_anchor);
    			if (detaching) html_tag.d();
    		}
    	};
    }

    // (306:16) {#if $isArabic}
    function create_if_block_5$2(ctx) {
    	let html_tag;
    	let raw_value = renderBlockText(/*curatorialMember*/ ctx[8].ar_bio) + "";
    	let html_anchor;

    	return {
    		c() {
    			html_tag = new HtmlTag(false);
    			html_anchor = empty();
    			html_tag.a = html_anchor;
    		},
    		m(target, anchor) {
    			html_tag.m(raw_value, target, anchor);
    			insert(target, html_anchor, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*page*/ 8 && raw_value !== (raw_value = renderBlockText(/*curatorialMember*/ ctx[8].ar_bio) + "")) html_tag.p(raw_value);
    		},
    		d(detaching) {
    			if (detaching) detach(html_anchor);
    			if (detaching) html_tag.d();
    		}
    	};
    }

    // (297:12) {#each page.curatorialTeam as curatorialMember}
    function create_each_block_1$1(ctx) {
    	let div0;
    	let t0;
    	let t1;
    	let div1;
    	let t2;
    	let t3;
    	let if_block0 = /*$isEnglish*/ ctx[2] && create_if_block_8$1(ctx);
    	let if_block1 = /*$isArabic*/ ctx[1] && create_if_block_7$1(ctx);
    	let if_block2 = /*$isEnglish*/ ctx[2] && create_if_block_6$1(ctx);
    	let if_block3 = /*$isArabic*/ ctx[1] && create_if_block_5$2(ctx);

    	return {
    		c() {
    			div0 = element("div");
    			if (if_block0) if_block0.c();
    			t0 = space();
    			if (if_block1) if_block1.c();
    			t1 = space();
    			div1 = element("div");
    			if (if_block2) if_block2.c();
    			t2 = space();
    			if (if_block3) if_block3.c();
    			t3 = space();
    			attr(div0, "class", "team-header team-title svelte-evc6nn");
    			attr(div1, "class", "team-body svelte-evc6nn");
    		},
    		m(target, anchor) {
    			insert(target, div0, anchor);
    			if (if_block0) if_block0.m(div0, null);
    			append(div0, t0);
    			if (if_block1) if_block1.m(div0, null);
    			insert(target, t1, anchor);
    			insert(target, div1, anchor);
    			if (if_block2) if_block2.m(div1, null);
    			append(div1, t2);
    			if (if_block3) if_block3.m(div1, null);
    			append(div1, t3);
    		},
    		p(ctx, dirty) {
    			if (/*$isEnglish*/ ctx[2]) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);
    				} else {
    					if_block0 = create_if_block_8$1(ctx);
    					if_block0.c();
    					if_block0.m(div0, t0);
    				}
    			} else if (if_block0) {
    				if_block0.d(1);
    				if_block0 = null;
    			}

    			if (/*$isArabic*/ ctx[1]) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);
    				} else {
    					if_block1 = create_if_block_7$1(ctx);
    					if_block1.c();
    					if_block1.m(div0, null);
    				}
    			} else if (if_block1) {
    				if_block1.d(1);
    				if_block1 = null;
    			}

    			if (/*$isEnglish*/ ctx[2]) {
    				if (if_block2) {
    					if_block2.p(ctx, dirty);
    				} else {
    					if_block2 = create_if_block_6$1(ctx);
    					if_block2.c();
    					if_block2.m(div1, t2);
    				}
    			} else if (if_block2) {
    				if_block2.d(1);
    				if_block2 = null;
    			}

    			if (/*$isArabic*/ ctx[1]) {
    				if (if_block3) {
    					if_block3.p(ctx, dirty);
    				} else {
    					if_block3 = create_if_block_5$2(ctx);
    					if_block3.c();
    					if_block3.m(div1, t3);
    				}
    			} else if (if_block3) {
    				if_block3.d(1);
    				if_block3 = null;
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(div0);
    			if (if_block0) if_block0.d();
    			if (if_block1) if_block1.d();
    			if (detaching) detach(t1);
    			if (detaching) detach(div1);
    			if (if_block2) if_block2.d();
    			if (if_block3) if_block3.d();
    		}
    	};
    }

    // (317:18) {#if $isEnglish}
    function create_if_block_4$2(ctx) {
    	let t_value = /*sharjahlMember*/ ctx[5].en_name + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*page*/ 8 && t_value !== (t_value = /*sharjahlMember*/ ctx[5].en_name + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (318:18) {#if $isArabic}
    function create_if_block_3$3(ctx) {
    	let t_value = /*sharjahlMember*/ ctx[5].ar_name + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*page*/ 8 && t_value !== (t_value = /*sharjahlMember*/ ctx[5].ar_name + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (321:16) {#if $isEnglish}
    function create_if_block_2$3(ctx) {
    	let t_value = /*sharjahlMember*/ ctx[5].en_position + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*page*/ 8 && t_value !== (t_value = /*sharjahlMember*/ ctx[5].en_position + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (322:16) {#if $isArabic}
    function create_if_block_1$5(ctx) {
    	let t_value = /*sharjahlMember*/ ctx[5].ar_position + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*page*/ 8 && t_value !== (t_value = /*sharjahlMember*/ ctx[5].ar_position + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (314:12) {#each page.sharjahTeam as sharjahlMember}
    function create_each_block$2(ctx) {
    	let div;
    	let a;
    	let t0;
    	let a_href_value;
    	let t1;
    	let br;
    	let t2;
    	let t3;
    	let t4;
    	let if_block0 = /*$isEnglish*/ ctx[2] && create_if_block_4$2(ctx);
    	let if_block1 = /*$isArabic*/ ctx[1] && create_if_block_3$3(ctx);
    	let if_block2 = /*$isEnglish*/ ctx[2] && create_if_block_2$3(ctx);
    	let if_block3 = /*$isArabic*/ ctx[1] && create_if_block_1$5(ctx);

    	return {
    		c() {
    			div = element("div");
    			a = element("a");
    			if (if_block0) if_block0.c();
    			t0 = space();
    			if (if_block1) if_block1.c();
    			t1 = space();
    			br = element("br");
    			t2 = space();
    			if (if_block2) if_block2.c();
    			t3 = space();
    			if (if_block3) if_block3.c();
    			t4 = space();
    			attr(a, "href", a_href_value = /*sharjahlMember*/ ctx[5].link);
    			attr(a, "target", "_blank");
    			attr(a, "rel", "noreferrer");
    			attr(a, "class", "svelte-evc6nn");
    			attr(div, "class", "team-header svelte-evc6nn");
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);
    			append(div, a);
    			if (if_block0) if_block0.m(a, null);
    			append(a, t0);
    			if (if_block1) if_block1.m(a, null);
    			append(div, t1);
    			append(div, br);
    			append(div, t2);
    			if (if_block2) if_block2.m(div, null);
    			append(div, t3);
    			if (if_block3) if_block3.m(div, null);
    			append(div, t4);
    		},
    		p(ctx, dirty) {
    			if (/*$isEnglish*/ ctx[2]) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);
    				} else {
    					if_block0 = create_if_block_4$2(ctx);
    					if_block0.c();
    					if_block0.m(a, t0);
    				}
    			} else if (if_block0) {
    				if_block0.d(1);
    				if_block0 = null;
    			}

    			if (/*$isArabic*/ ctx[1]) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);
    				} else {
    					if_block1 = create_if_block_3$3(ctx);
    					if_block1.c();
    					if_block1.m(a, null);
    				}
    			} else if (if_block1) {
    				if_block1.d(1);
    				if_block1 = null;
    			}

    			if (dirty & /*page*/ 8 && a_href_value !== (a_href_value = /*sharjahlMember*/ ctx[5].link)) {
    				attr(a, "href", a_href_value);
    			}

    			if (/*$isEnglish*/ ctx[2]) {
    				if (if_block2) {
    					if_block2.p(ctx, dirty);
    				} else {
    					if_block2 = create_if_block_2$3(ctx);
    					if_block2.c();
    					if_block2.m(div, t3);
    				}
    			} else if (if_block2) {
    				if_block2.d(1);
    				if_block2 = null;
    			}

    			if (/*$isArabic*/ ctx[1]) {
    				if (if_block3) {
    					if_block3.p(ctx, dirty);
    				} else {
    					if_block3 = create_if_block_1$5(ctx);
    					if_block3.c();
    					if_block3.m(div, t4);
    				}
    			} else if (if_block3) {
    				if_block3.d(1);
    				if_block3 = null;
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(div);
    			if (if_block0) if_block0.d();
    			if (if_block1) if_block1.d();
    			if (if_block2) if_block2.d();
    			if (if_block3) if_block3.d();
    		}
    	};
    }

    // (286:15)       <div />    {:then page}
    function create_pending_block$3(ctx) {
    	let div;

    	return {
    		c() {
    			div = element("div");
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);
    		},
    		p: noop$1,
    		i: noop$1,
    		o: noop$1,
    		d(detaching) {
    			if (detaching) detach(div);
    		}
    	};
    }

    function create_fragment$8(ctx) {
    	let promise;
    	let t;
    	let div;
    	let promise_1;
    	let current;

    	let info = {
    		ctx,
    		current: null,
    		token: null,
    		hasCatch: false,
    		pending: create_pending_block_1$2,
    		then: create_then_block_1$2,
    		catch: create_catch_block_1$2,
    		value: 3,
    		blocks: [,,,]
    	};

    	handle_promise(promise = /*page*/ ctx[3], info);

    	let info_1 = {
    		ctx,
    		current: null,
    		token: null,
    		hasCatch: true,
    		pending: create_pending_block$3,
    		then: create_then_block$3,
    		catch: create_catch_block$3,
    		value: 3,
    		error: 11,
    		blocks: [,,,]
    	};

    	handle_promise(promise_1 = /*page*/ ctx[3], info_1);

    	return {
    		c() {
    			info.block.c();
    			t = space();
    			div = element("div");
    			info_1.block.c();
    			attr(div, "class", "page-view svelte-evc6nn");
    		},
    		m(target, anchor) {
    			info.block.m(target, info.anchor = anchor);
    			info.mount = () => t.parentNode;
    			info.anchor = t;
    			insert(target, t, anchor);
    			insert(target, div, anchor);
    			info_1.block.m(div, info_1.anchor = null);
    			info_1.mount = () => div;
    			info_1.anchor = null;
    			current = true;
    		},
    		p(new_ctx, [dirty]) {
    			ctx = new_ctx;
    			info.ctx = ctx;

    			if (dirty & /*page*/ 8 && promise !== (promise = /*page*/ ctx[3]) && handle_promise(promise, info)) ; else {
    				update_await_block_branch(info, ctx, dirty);
    			}

    			info_1.ctx = ctx;

    			if (dirty & /*page*/ 8 && promise_1 !== (promise_1 = /*page*/ ctx[3]) && handle_promise(promise_1, info_1)) ; else {
    				update_await_block_branch(info_1, ctx, dirty);
    			}
    		},
    		i(local) {
    			if (current) return;
    			transition_in(info.block);
    			transition_in(info_1.block);
    			current = true;
    		},
    		o(local) {
    			for (let i = 0; i < 3; i += 1) {
    				const block = info.blocks[i];
    				transition_out(block);
    			}

    			for (let i = 0; i < 3; i += 1) {
    				const block = info_1.blocks[i];
    				transition_out(block);
    			}

    			current = false;
    		},
    		d(detaching) {
    			info.block.d(detaching);
    			info.token = null;
    			info = null;
    			if (detaching) detach(t);
    			if (detaching) detach(div);
    			info_1.block.d();
    			info_1.token = null;
    			info_1 = null;
    		}
    	};
    }

    // ** CONSTANTS
    const query$4 = '*[_type == "page" && slug.current == $slug][0]';

    function instance$7($$self, $$props, $$invalidate) {
    	let $isArabic;
    	let $isEnglish;
    	component_subscribe($$self, isArabic, $$value => $$invalidate(1, $isArabic = $$value));
    	component_subscribe($$self, isEnglish, $$value => $$invalidate(2, $isEnglish = $$value));
    	let { slug = {} } = $$props;
    	let { language = "" } = $$props;

    	// ** VARIABLES
    	let page = {};

    	// Set globals
    	globalLanguage.set(language === "ar" ? "arabic" : "english");

    	onMount(async () => {
    		window.scrollTo(0, 0);
    	});

    	$$self.$$set = $$props => {
    		if ('slug' in $$props) $$invalidate(0, slug = $$props.slug);
    		if ('language' in $$props) $$invalidate(4, language = $$props.language);
    	};

    	$$self.$$.update = () => {
    		if ($$self.$$.dirty & /*slug*/ 1) {
    			{
    				$$invalidate(3, page = loadSingleData(query$4, { slug }));
    			}
    		}

    		if ($$self.$$.dirty & /*slug*/ 1) {
    			{
    				activeNavigation.set(slug ? slug : "");
    			}
    		}
    	};

    	return [slug, $isArabic, $isEnglish, page, language];
    }

    class PageView extends SvelteComponent {
    	constructor(options) {
    		super();
    		init(this, options, instance$7, create_fragment$8, safe_not_equal, { slug: 0, language: 4 });
    	}
    }

    /* src\Components\InternalLink.svelte generated by Svelte v3.58.0 */

    function create_if_block_1$4(ctx) {
    	let t_value = /*post*/ ctx[0].title.english + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 1 && t_value !== (t_value = /*post*/ ctx[0].title.english + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (235:10) {#if $isArabic}
    function create_if_block$5(ctx) {
    	let t_value = /*post*/ ctx[0].title.arabic + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 1 && t_value !== (t_value = /*post*/ ctx[0].title.arabic + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (222:0) <Router>
    function create_default_slot$3(ctx) {
    	let div3;
    	let a;
    	let div2;
    	let div0;
    	let t0;
    	let div0_intro;
    	let t1;
    	let div1;
    	let t2;
    	let div1_intro;
    	let div2_class_value;
    	let a_href_value;
    	let mounted;
    	let dispose;
    	let if_block0 = /*$isEnglish*/ ctx[4] && create_if_block_1$4(ctx);
    	let if_block1 = /*$isArabic*/ ctx[5] && create_if_block$5(ctx);

    	return {
    		c() {
    			div3 = element("div");
    			a = element("a");
    			div2 = element("div");
    			div0 = element("div");
    			t0 = text(/*categoryDisplayName*/ ctx[2]);
    			t1 = space();
    			div1 = element("div");
    			if (if_block0) if_block0.c();
    			t2 = space();
    			if (if_block1) if_block1.c();
    			attr(div0, "class", "cross-link-category svelte-62ojp7");
    			attr(div1, "class", "cross-link-title svelte-62ojp7");
    			attr(div2, "class", div2_class_value = "cross-link-bar " + /*color*/ ctx[1] + " svelte-62ojp7");
    			attr(a, "href", a_href_value = "/" + /*$languagePrefix*/ ctx[3] + "/" + /*post*/ ctx[0].category + "/" + /*post*/ ctx[0].slug);
    			attr(div3, "class", "cross-link width-100 svelte-62ojp7");
    		},
    		m(target, anchor) {
    			insert(target, div3, anchor);
    			append(div3, a);
    			append(a, div2);
    			append(div2, div0);
    			append(div0, t0);
    			append(div2, t1);
    			append(div2, div1);
    			if (if_block0) if_block0.m(div1, null);
    			append(div1, t2);
    			if (if_block1) if_block1.m(div1, null);

    			if (!mounted) {
    				dispose = action_destroyer(links.call(null, div3));
    				mounted = true;
    			}
    		},
    		p(ctx, dirty) {
    			if (dirty & /*categoryDisplayName*/ 4) set_data(t0, /*categoryDisplayName*/ ctx[2]);

    			if (/*$isEnglish*/ ctx[4]) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);
    				} else {
    					if_block0 = create_if_block_1$4(ctx);
    					if_block0.c();
    					if_block0.m(div1, t2);
    				}
    			} else if (if_block0) {
    				if_block0.d(1);
    				if_block0 = null;
    			}

    			if (/*$isArabic*/ ctx[5]) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);
    				} else {
    					if_block1 = create_if_block$5(ctx);
    					if_block1.c();
    					if_block1.m(div1, null);
    				}
    			} else if (if_block1) {
    				if_block1.d(1);
    				if_block1 = null;
    			}

    			if (dirty & /*color*/ 2 && div2_class_value !== (div2_class_value = "cross-link-bar " + /*color*/ ctx[1] + " svelte-62ojp7")) {
    				attr(div2, "class", div2_class_value);
    			}

    			if (dirty & /*$languagePrefix, post*/ 9 && a_href_value !== (a_href_value = "/" + /*$languagePrefix*/ ctx[3] + "/" + /*post*/ ctx[0].category + "/" + /*post*/ ctx[0].slug)) {
    				attr(a, "href", a_href_value);
    			}
    		},
    		i(local) {
    			if (!div0_intro) {
    				add_render_callback(() => {
    					div0_intro = create_in_transition(div0, fly, { duration: 150, delay: 0, y: 10 });
    					div0_intro.start();
    				});
    			}

    			if (!div1_intro) {
    				add_render_callback(() => {
    					div1_intro = create_in_transition(div1, fly, { duration: 150, delay: 100, y: 10 });
    					div1_intro.start();
    				});
    			}
    		},
    		o: noop$1,
    		d(detaching) {
    			if (detaching) detach(div3);
    			if (if_block0) if_block0.d();
    			if (if_block1) if_block1.d();
    			mounted = false;
    			dispose();
    		}
    	};
    }

    function create_fragment$7(ctx) {
    	let router;
    	let current;

    	router = new Router({
    			props: {
    				$$slots: { default: [create_default_slot$3] },
    				$$scope: { ctx }
    			}
    		});

    	return {
    		c() {
    			create_component(router.$$.fragment);
    		},
    		m(target, anchor) {
    			mount_component(router, target, anchor);
    			current = true;
    		},
    		p(ctx, [dirty]) {
    			const router_changes = {};

    			if (dirty & /*$$scope, $languagePrefix, post, color, $isArabic, $isEnglish, categoryDisplayName*/ 191) {
    				router_changes.$$scope = { dirty, ctx };
    			}

    			router.$set(router_changes);
    		},
    		i(local) {
    			if (current) return;
    			transition_in(router.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(router.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			destroy_component(router, detaching);
    		}
    	};
    }

    function instance$6($$self, $$props, $$invalidate) {
    	let $categoryList;
    	let $languagePrefix;
    	let $isEnglish;
    	let $isArabic;
    	component_subscribe($$self, categoryList, $$value => $$invalidate(6, $categoryList = $$value));
    	component_subscribe($$self, languagePrefix, $$value => $$invalidate(3, $languagePrefix = $$value));
    	component_subscribe($$self, isEnglish, $$value => $$invalidate(4, $isEnglish = $$value));
    	component_subscribe($$self, isArabic, $$value => $$invalidate(5, $isArabic = $$value));
    	let { post = {} } = $$props;

    	// ** VARIABLES
    	let color = "";

    	let categoryDisplayName = "";

    	$$self.$$set = $$props => {
    		if ('post' in $$props) $$invalidate(0, post = $$props.post);
    	};

    	$$self.$$.update = () => {
    		if ($$self.$$.dirty & /*post, $categoryList*/ 65) {
    			// >>> RE-USE
    			{
    				if (post.category === "event") {
    					$$invalidate(2, categoryDisplayName = "Opening Programme");
    					$$invalidate(1, color = "rfgen-grey");
    					$$invalidate(0, post.slug = "", post);
    					$$invalidate(0, post.category = "programme", post);
    				} else {
    					let matchingCategory = $categoryList.find(cat => cat.categorySlug === kebabCase_1(post.category));

    					$$invalidate(1, color = matchingCategory
    					? matchingCategory.color
    					: "rfgen-white");

    					$$invalidate(2, categoryDisplayName = get_1(matchingCategory, "nameDisplay.english", false));
    				}
    			}
    		}
    	};

    	return [
    		post,
    		color,
    		categoryDisplayName,
    		$languagePrefix,
    		$isEnglish,
    		$isArabic,
    		$categoryList
    	];
    }

    class InternalLink extends SvelteComponent {
    	constructor(options) {
    		super();
    		init(this, options, instance$6, create_fragment$7, safe_not_equal, { post: 0 });
    	}
    }

    /* src\Components\Video.svelte generated by Svelte v3.58.0 */

    function create_else_block$1(ctx) {
    	let iframe;
    	let iframe_src_value;

    	return {
    		c() {
    			iframe = element("iframe");
    			if (!src_url_equal(iframe.src, iframe_src_value = "https://player.vimeo.com/video/" + /*id*/ ctx[2] + "?autoplay=1")) attr(iframe, "src", iframe_src_value);
    			attr(iframe, "width", "1280");
    			attr(iframe, "height", "720");
    			attr(iframe, "title", "rfgen");
    			attr(iframe, "frameborder", "0");
    			attr(iframe, "byline", "false");
    			attr(iframe, "color", "#ffffff");
    			attr(iframe, "allow", "autoplay; fullscreen");
    			iframe.allowFullscreen = true;
    			attr(iframe, "class", "svelte-1njrl5v");
    			toggle_class(iframe, "visible", /*playing*/ ctx[1]);
    		},
    		m(target, anchor) {
    			insert(target, iframe, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*playing*/ 2) {
    				toggle_class(iframe, "visible", /*playing*/ ctx[1]);
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(iframe);
    		}
    	};
    }

    // (194:0) {#if !playing}
    function create_if_block$4(ctx) {
    	let img;
    	let img_src_value;
    	let t;
    	let svg;
    	let polygon;
    	let mounted;
    	let dispose;

    	return {
    		c() {
    			img = element("img");
    			t = space();
    			svg = svg_element("svg");
    			polygon = svg_element("polygon");
    			attr(img, "class", "poster svelte-1njrl5v");
    			if (!src_url_equal(img.src, img_src_value = urlFor(/*posterImage*/ ctx[0]).quality(80).height(1080).width(1920).auto('format').url())) attr(img, "src", img_src_value);
    			attr(img, "alt", "");
    			attr(img, "width", "1280");
    			attr(img, "height", "720");
    			toggle_class(img, "visible", !/*playing*/ ctx[1]);
    			attr(polygon, "points", "5 3 19 12 5 21 5 3");
    			attr(svg, "xmlns", "http://www.w3.org/2000/svg");
    			attr(svg, "viewBox", "0 0 24 24");
    			attr(svg, "fill", "none");
    			attr(svg, "stroke", "currentColor");
    			attr(svg, "stroke-width", "0.2");
    			attr(svg, "class", "feather feather-play play svelte-1njrl5v");
    		},
    		m(target, anchor) {
    			insert(target, img, anchor);
    			insert(target, t, anchor);
    			insert(target, svg, anchor);
    			append(svg, polygon);

    			if (!mounted) {
    				dispose = listen$1(img, "click", /*click_handler*/ ctx[4]);
    				mounted = true;
    			}
    		},
    		p(ctx, dirty) {
    			if (dirty & /*posterImage*/ 1 && !src_url_equal(img.src, img_src_value = urlFor(/*posterImage*/ ctx[0]).quality(80).height(1080).width(1920).auto('format').url())) {
    				attr(img, "src", img_src_value);
    			}

    			if (dirty & /*playing*/ 2) {
    				toggle_class(img, "visible", !/*playing*/ ctx[1]);
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(img);
    			if (detaching) detach(t);
    			if (detaching) detach(svg);
    			mounted = false;
    			dispose();
    		}
    	};
    }

    function create_fragment$6(ctx) {
    	let if_block_anchor;

    	function select_block_type(ctx, dirty) {
    		if (!/*playing*/ ctx[1]) return create_if_block$4;
    		return create_else_block$1;
    	}

    	let current_block_type = select_block_type(ctx);
    	let if_block = current_block_type(ctx);

    	return {
    		c() {
    			if_block.c();
    			if_block_anchor = empty();
    		},
    		m(target, anchor) {
    			if_block.m(target, anchor);
    			insert(target, if_block_anchor, anchor);
    		},
    		p(ctx, [dirty]) {
    			if (current_block_type === (current_block_type = select_block_type(ctx)) && if_block) {
    				if_block.p(ctx, dirty);
    			} else {
    				if_block.d(1);
    				if_block = current_block_type(ctx);

    				if (if_block) {
    					if_block.c();
    					if_block.m(if_block_anchor.parentNode, if_block_anchor);
    				}
    			}
    		},
    		i: noop$1,
    		o: noop$1,
    		d(detaching) {
    			if_block.d(detaching);
    			if (detaching) detach(if_block_anchor);
    		}
    	};
    }

    function instance$5($$self, $$props, $$invalidate) {
    	let { url = "" } = $$props;
    	let { posterImage = "" } = $$props;

    	// *** VARIABLES
    	const id = url.match(/([0-9])\w+/g)[0];

    	let playing = false;
    	const click_handler = () => $$invalidate(1, playing = true);

    	$$self.$$set = $$props => {
    		if ('url' in $$props) $$invalidate(3, url = $$props.url);
    		if ('posterImage' in $$props) $$invalidate(0, posterImage = $$props.posterImage);
    	};

    	return [posterImage, playing, id, url, click_handler];
    }

    class Video extends SvelteComponent {
    	constructor(options) {
    		super();
    		init(this, options, instance$5, create_fragment$6, safe_not_equal, { url: 3, posterImage: 0 });
    	}
    }

    /* src\Views\PostView.svelte generated by Svelte v3.58.0 */

    function get_each_context$1(ctx, list, i) {
    	const child_ctx = ctx.slice();
    	child_ctx[10] = list[i];
    	return child_ctx;
    }

    // (1:0) <script>    // # # # # # # # # # # # # #    //    //  PostView    //    // # # # # # # # # # # # # #      // *** IMPORT    import { onMount }
    function create_catch_block_1$1(ctx) {
    	return {
    		c: noop$1,
    		m: noop$1,
    		p: noop$1,
    		i: noop$1,
    		o: noop$1,
    		d: noop$1
    	};
    }

    // (518:23)     <MetaData {post}
    function create_then_block_1$1(ctx) {
    	let metadata;
    	let current;
    	metadata = new MetaData({ props: { post: /*post*/ ctx[4] } });

    	return {
    		c() {
    			create_component(metadata.$$.fragment);
    		},
    		m(target, anchor) {
    			mount_component(metadata, target, anchor);
    			current = true;
    		},
    		p(ctx, dirty) {
    			const metadata_changes = {};
    			if (dirty & /*post*/ 16) metadata_changes.post = /*post*/ ctx[4];
    			metadata.$set(metadata_changes);
    		},
    		i(local) {
    			if (current) return;
    			transition_in(metadata.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(metadata.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			destroy_component(metadata, detaching);
    		}
    	};
    }

    // (1:0) <script>    // # # # # # # # # # # # # #    //    //  PostView    //    // # # # # # # # # # # # # #      // *** IMPORT    import { onMount }
    function create_pending_block_1$1(ctx) {
    	return {
    		c: noop$1,
    		m: noop$1,
    		p: noop$1,
    		i: noop$1,
    		o: noop$1,
    		d: noop$1
    	};
    }

    // (575:2) {:catch error}
    function create_catch_block$2(ctx) {
    	let router;
    	let current;

    	router = new Router({
    			props: {
    				$$slots: { default: [create_default_slot$2] },
    				$$scope: { ctx }
    			}
    		});

    	return {
    		c() {
    			create_component(router.$$.fragment);
    		},
    		m(target, anchor) {
    			mount_component(router, target, anchor);
    			current = true;
    		},
    		p(ctx, dirty) {
    			const router_changes = {};

    			if (dirty & /*$$scope, post*/ 16400) {
    				router_changes.$$scope = { dirty, ctx };
    			}

    			router.$set(router_changes);
    		},
    		i(local) {
    			if (current) return;
    			transition_in(router.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(router.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			destroy_component(router, detaching);
    		}
    	};
    }

    // (576:4) <Router>
    function create_default_slot$2(ctx) {
    	let div1;
    	let div0;
    	let t0;
    	let t1_value = /*error*/ ctx[13].message + "";
    	let t1;
    	let t2;
    	let a;
    	let mounted;
    	let dispose;

    	return {
    		c() {
    			div1 = element("div");
    			div0 = element("div");
    			t0 = text("Error: ");
    			t1 = text(t1_value);
    			t2 = space();
    			a = element("a");
    			a.textContent = "Return to home page";
    			attr(div0, "class", "msg");
    			attr(a, "href", "/");
    			attr(a, "class", "svelte-1nxgrob");
    			attr(div1, "class", "error svelte-1nxgrob");
    		},
    		m(target, anchor) {
    			insert(target, div1, anchor);
    			append(div1, div0);
    			append(div0, t0);
    			append(div0, t1);
    			append(div1, t2);
    			append(div1, a);

    			if (!mounted) {
    				dispose = action_destroyer(links.call(null, div1));
    				mounted = true;
    			}
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 16 && t1_value !== (t1_value = /*error*/ ctx[13].message + "")) set_data(t1, t1_value);
    		},
    		d(detaching) {
    			if (detaching) detach(div1);
    			mounted = false;
    			dispose();
    		}
    	};
    }

    // (525:2) {:then post}
    function create_then_block$2(ctx) {
    	let t0;
    	let t1;
    	let div6;
    	let div3;
    	let div0;

    	let t2_value = (/*post*/ ctx[4].category === 'workingGroup'
    	? 'Working group'
    	: /*post*/ ctx[4].category) + "";

    	let t2;
    	let t3;
    	let div1;
    	let t4;
    	let t5;
    	let div2;
    	let t6;
    	let t7;
    	let div5;
    	let div4;
    	let div6_intro;
    	let current;
    	let if_block0 = /*post*/ ctx[4].videoLink && create_if_block_5$1(ctx);
    	let if_block1 = /*post*/ ctx[4].mainImage && !/*post*/ ctx[4].videoLink && create_if_block_4$1(ctx);
    	let if_block2 = /*$isEnglish*/ ctx[3] && create_if_block_3$2(ctx);
    	let if_block3 = /*$isArabic*/ ctx[2] && create_if_block_2$2(ctx);
    	let if_block4 = /*$isEnglish*/ ctx[3] && create_if_block_1$3(ctx);
    	let if_block5 = /*$isArabic*/ ctx[2] && create_if_block$3(ctx);
    	let each_value = /*post*/ ctx[4].links;
    	let each_blocks = [];

    	for (let i = 0; i < each_value.length; i += 1) {
    		each_blocks[i] = create_each_block$1(get_each_context$1(ctx, each_value, i));
    	}

    	const out = i => transition_out(each_blocks[i], 1, 1, () => {
    		each_blocks[i] = null;
    	});

    	return {
    		c() {
    			if (if_block0) if_block0.c();
    			t0 = space();
    			if (if_block1) if_block1.c();
    			t1 = space();
    			div6 = element("div");
    			div3 = element("div");
    			div0 = element("div");
    			t2 = text(t2_value);
    			t3 = space();
    			div1 = element("div");
    			if (if_block2) if_block2.c();
    			t4 = space();
    			if (if_block3) if_block3.c();
    			t5 = space();
    			div2 = element("div");
    			if (if_block4) if_block4.c();
    			t6 = space();
    			if (if_block5) if_block5.c();
    			t7 = space();
    			div5 = element("div");
    			div4 = element("div");

    			for (let i = 0; i < each_blocks.length; i += 1) {
    				each_blocks[i].c();
    			}

    			attr(div0, "class", "post-view-category svelte-1nxgrob");
    			toggle_class(div0, "arabic", /*$isArabic*/ ctx[2]);
    			attr(div1, "class", "post-view-title svelte-1nxgrob");
    			toggle_class(div1, "arabic", /*$isArabic*/ ctx[2]);
    			attr(div2, "class", "post-view-text-inner svelte-1nxgrob");
    			toggle_class(div2, "arabic", /*$isArabic*/ ctx[2]);
    			attr(div3, "class", "post-view-column left svelte-1nxgrob");
    			toggle_class(div3, "arabic", /*$isArabic*/ ctx[2]);
    			attr(div4, "class", "links-container");
    			toggle_class(div4, "video", /*post*/ ctx[4].videoLink);
    			attr(div5, "class", "post-view-column right svelte-1nxgrob");
    			toggle_class(div5, "arabic", /*$isArabic*/ ctx[2]);
    			attr(div6, "class", "post-view-text svelte-1nxgrob");
    			toggle_class(div6, "arabic", /*$isArabic*/ ctx[2]);
    			toggle_class(div6, "video", /*post*/ ctx[4].videoLink);
    		},
    		m(target, anchor) {
    			if (if_block0) if_block0.m(target, anchor);
    			insert(target, t0, anchor);
    			if (if_block1) if_block1.m(target, anchor);
    			insert(target, t1, anchor);
    			insert(target, div6, anchor);
    			append(div6, div3);
    			append(div3, div0);
    			append(div0, t2);
    			append(div3, t3);
    			append(div3, div1);
    			if (if_block2) if_block2.m(div1, null);
    			append(div1, t4);
    			if (if_block3) if_block3.m(div1, null);
    			append(div3, t5);
    			append(div3, div2);
    			if (if_block4) if_block4.m(div2, null);
    			append(div2, t6);
    			if (if_block5) if_block5.m(div2, null);
    			append(div6, t7);
    			append(div6, div5);
    			append(div5, div4);

    			for (let i = 0; i < each_blocks.length; i += 1) {
    				if (each_blocks[i]) {
    					each_blocks[i].m(div4, null);
    				}
    			}

    			current = true;
    		},
    		p(ctx, dirty) {
    			if (/*post*/ ctx[4].videoLink) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);

    					if (dirty & /*post*/ 16) {
    						transition_in(if_block0, 1);
    					}
    				} else {
    					if_block0 = create_if_block_5$1(ctx);
    					if_block0.c();
    					transition_in(if_block0, 1);
    					if_block0.m(t0.parentNode, t0);
    				}
    			} else if (if_block0) {
    				group_outros();

    				transition_out(if_block0, 1, 1, () => {
    					if_block0 = null;
    				});

    				check_outros();
    			}

    			if (/*post*/ ctx[4].mainImage && !/*post*/ ctx[4].videoLink) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);
    				} else {
    					if_block1 = create_if_block_4$1(ctx);
    					if_block1.c();
    					if_block1.m(t1.parentNode, t1);
    				}
    			} else if (if_block1) {
    				if_block1.d(1);
    				if_block1 = null;
    			}

    			if ((!current || dirty & /*post*/ 16) && t2_value !== (t2_value = (/*post*/ ctx[4].category === 'workingGroup'
    			? 'Working group'
    			: /*post*/ ctx[4].category) + "")) set_data(t2, t2_value);

    			if (!current || dirty & /*$isArabic*/ 4) {
    				toggle_class(div0, "arabic", /*$isArabic*/ ctx[2]);
    			}

    			if (/*$isEnglish*/ ctx[3]) {
    				if (if_block2) {
    					if_block2.p(ctx, dirty);
    				} else {
    					if_block2 = create_if_block_3$2(ctx);
    					if_block2.c();
    					if_block2.m(div1, t4);
    				}
    			} else if (if_block2) {
    				if_block2.d(1);
    				if_block2 = null;
    			}

    			if (/*$isArabic*/ ctx[2]) {
    				if (if_block3) {
    					if_block3.p(ctx, dirty);
    				} else {
    					if_block3 = create_if_block_2$2(ctx);
    					if_block3.c();
    					if_block3.m(div1, null);
    				}
    			} else if (if_block3) {
    				if_block3.d(1);
    				if_block3 = null;
    			}

    			if (!current || dirty & /*$isArabic*/ 4) {
    				toggle_class(div1, "arabic", /*$isArabic*/ ctx[2]);
    			}

    			if (/*$isEnglish*/ ctx[3]) {
    				if (if_block4) {
    					if_block4.p(ctx, dirty);
    				} else {
    					if_block4 = create_if_block_1$3(ctx);
    					if_block4.c();
    					if_block4.m(div2, t6);
    				}
    			} else if (if_block4) {
    				if_block4.d(1);
    				if_block4 = null;
    			}

    			if (/*$isArabic*/ ctx[2]) {
    				if (if_block5) {
    					if_block5.p(ctx, dirty);
    				} else {
    					if_block5 = create_if_block$3(ctx);
    					if_block5.c();
    					if_block5.m(div2, null);
    				}
    			} else if (if_block5) {
    				if_block5.d(1);
    				if_block5 = null;
    			}

    			if (!current || dirty & /*$isArabic*/ 4) {
    				toggle_class(div2, "arabic", /*$isArabic*/ ctx[2]);
    			}

    			if (!current || dirty & /*$isArabic*/ 4) {
    				toggle_class(div3, "arabic", /*$isArabic*/ ctx[2]);
    			}

    			if (dirty & /*post*/ 16) {
    				each_value = /*post*/ ctx[4].links;
    				let i;

    				for (i = 0; i < each_value.length; i += 1) {
    					const child_ctx = get_each_context$1(ctx, each_value, i);

    					if (each_blocks[i]) {
    						each_blocks[i].p(child_ctx, dirty);
    						transition_in(each_blocks[i], 1);
    					} else {
    						each_blocks[i] = create_each_block$1(child_ctx);
    						each_blocks[i].c();
    						transition_in(each_blocks[i], 1);
    						each_blocks[i].m(div4, null);
    					}
    				}

    				group_outros();

    				for (i = each_value.length; i < each_blocks.length; i += 1) {
    					out(i);
    				}

    				check_outros();
    			}

    			if (!current || dirty & /*post*/ 16) {
    				toggle_class(div4, "video", /*post*/ ctx[4].videoLink);
    			}

    			if (!current || dirty & /*$isArabic*/ 4) {
    				toggle_class(div5, "arabic", /*$isArabic*/ ctx[2]);
    			}

    			if (!current || dirty & /*$isArabic*/ 4) {
    				toggle_class(div6, "arabic", /*$isArabic*/ ctx[2]);
    			}

    			if (!current || dirty & /*post*/ 16) {
    				toggle_class(div6, "video", /*post*/ ctx[4].videoLink);
    			}
    		},
    		i(local) {
    			if (current) return;
    			transition_in(if_block0);

    			for (let i = 0; i < each_value.length; i += 1) {
    				transition_in(each_blocks[i]);
    			}

    			if (!div6_intro) {
    				add_render_callback(() => {
    					div6_intro = create_in_transition(div6, fade, {});
    					div6_intro.start();
    				});
    			}

    			current = true;
    		},
    		o(local) {
    			transition_out(if_block0);
    			each_blocks = each_blocks.filter(Boolean);

    			for (let i = 0; i < each_blocks.length; i += 1) {
    				transition_out(each_blocks[i]);
    			}

    			current = false;
    		},
    		d(detaching) {
    			if (if_block0) if_block0.d(detaching);
    			if (detaching) detach(t0);
    			if (if_block1) if_block1.d(detaching);
    			if (detaching) detach(t1);
    			if (detaching) detach(div6);
    			if (if_block2) if_block2.d();
    			if (if_block3) if_block3.d();
    			if (if_block4) if_block4.d();
    			if (if_block5) if_block5.d();
    			destroy_each(each_blocks, detaching);
    		}
    	};
    }

    // (526:4) {#if post.videoLink}
    function create_if_block_5$1(ctx) {
    	let div;
    	let video;
    	let current;

    	video = new Video({
    			props: {
    				url: /*post*/ ctx[4].videoLink,
    				posterImage: /*post*/ ctx[4].posterImage
    			}
    		});

    	return {
    		c() {
    			div = element("div");
    			create_component(video.$$.fragment);
    			attr(div, "class", "video-container svelte-1nxgrob");
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);
    			mount_component(video, div, null);
    			current = true;
    		},
    		p(ctx, dirty) {
    			const video_changes = {};
    			if (dirty & /*post*/ 16) video_changes.url = /*post*/ ctx[4].videoLink;
    			if (dirty & /*post*/ 16) video_changes.posterImage = /*post*/ ctx[4].posterImage;
    			video.$set(video_changes);
    		},
    		i(local) {
    			if (current) return;
    			transition_in(video.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(video.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			if (detaching) detach(div);
    			destroy_component(video);
    		}
    	};
    }

    // (531:4) {#if post.mainImage && !post.videoLink}
    function create_if_block_4$1(ctx) {
    	let div;
    	let img;
    	let img_src_value;
    	let img_alt_value;
    	let mounted;
    	let dispose;

    	return {
    		c() {
    			div = element("div");
    			img = element("img");
    			if (!src_url_equal(img.src, img_src_value = urlFor(/*post*/ ctx[4].mainImage).height(1200).width(1000).quality(90).auto('format').url())) attr(img, "src", img_src_value);

    			attr(img, "alt", img_alt_value = /*$isEnglish*/ ctx[3]
    			? /*post*/ ctx[4].title.english
    			: /*post*/ ctx[4].title.arabic);

    			attr(img, "class", "svelte-1nxgrob");
    			toggle_class(img, "loaded", /*loaded*/ ctx[1]);
    			attr(div, "class", "post-view-image svelte-1nxgrob");
    			toggle_class(div, "arabic", /*$isArabic*/ ctx[2]);
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);
    			append(div, img);
    			/*div_binding*/ ctx[9](div);

    			if (!mounted) {
    				dispose = listen$1(img, "load", /*load_handler*/ ctx[8]);
    				mounted = true;
    			}
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 16 && !src_url_equal(img.src, img_src_value = urlFor(/*post*/ ctx[4].mainImage).height(1200).width(1000).quality(90).auto('format').url())) {
    				attr(img, "src", img_src_value);
    			}

    			if (dirty & /*$isEnglish, post*/ 24 && img_alt_value !== (img_alt_value = /*$isEnglish*/ ctx[3]
    			? /*post*/ ctx[4].title.english
    			: /*post*/ ctx[4].title.arabic)) {
    				attr(img, "alt", img_alt_value);
    			}

    			if (dirty & /*loaded*/ 2) {
    				toggle_class(img, "loaded", /*loaded*/ ctx[1]);
    			}

    			if (dirty & /*$isArabic*/ 4) {
    				toggle_class(div, "arabic", /*$isArabic*/ ctx[2]);
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(div);
    			/*div_binding*/ ctx[9](null);
    			mounted = false;
    			dispose();
    		}
    	};
    }

    // (555:10) {#if $isEnglish}
    function create_if_block_3$2(ctx) {
    	let t_value = /*post*/ ctx[4].title.english + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 16 && t_value !== (t_value = /*post*/ ctx[4].title.english + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (556:10) {#if $isArabic}
    function create_if_block_2$2(ctx) {
    	let t_value = /*post*/ ctx[4].title.arabic + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 16 && t_value !== (t_value = /*post*/ ctx[4].title.arabic + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (559:10) {#if $isEnglish}
    function create_if_block_1$3(ctx) {
    	let html_tag;
    	let raw_value = renderBlockText(/*post*/ ctx[4].content.english) + "";
    	let html_anchor;

    	return {
    		c() {
    			html_tag = new HtmlTag(false);
    			html_anchor = empty();
    			html_tag.a = html_anchor;
    		},
    		m(target, anchor) {
    			html_tag.m(raw_value, target, anchor);
    			insert(target, html_anchor, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 16 && raw_value !== (raw_value = renderBlockText(/*post*/ ctx[4].content.english) + "")) html_tag.p(raw_value);
    		},
    		d(detaching) {
    			if (detaching) detach(html_anchor);
    			if (detaching) html_tag.d();
    		}
    	};
    }

    // (562:10) {#if $isArabic}
    function create_if_block$3(ctx) {
    	let html_tag;
    	let raw_value = renderBlockText(/*post*/ ctx[4].content.arabic) + "";
    	let html_anchor;

    	return {
    		c() {
    			html_tag = new HtmlTag(false);
    			html_anchor = empty();
    			html_tag.a = html_anchor;
    		},
    		m(target, anchor) {
    			html_tag.m(raw_value, target, anchor);
    			insert(target, html_anchor, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 16 && raw_value !== (raw_value = renderBlockText(/*post*/ ctx[4].content.arabic) + "")) html_tag.p(raw_value);
    		},
    		d(detaching) {
    			if (detaching) detach(html_anchor);
    			if (detaching) html_tag.d();
    		}
    	};
    }

    // (569:10) {#each post.links as link}
    function create_each_block$1(ctx) {
    	let internallink;
    	let current;
    	internallink = new InternalLink({ props: { post: /*link*/ ctx[10] } });

    	return {
    		c() {
    			create_component(internallink.$$.fragment);
    		},
    		m(target, anchor) {
    			mount_component(internallink, target, anchor);
    			current = true;
    		},
    		p(ctx, dirty) {
    			const internallink_changes = {};
    			if (dirty & /*post*/ 16) internallink_changes.post = /*link*/ ctx[10];
    			internallink.$set(internallink_changes);
    		},
    		i(local) {
    			if (current) return;
    			transition_in(internallink.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(internallink.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			destroy_component(internallink, detaching);
    		}
    	};
    }

    // (523:15)       <div />    {:then post}
    function create_pending_block$2(ctx) {
    	let div;

    	return {
    		c() {
    			div = element("div");
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);
    		},
    		p: noop$1,
    		i: noop$1,
    		o: noop$1,
    		d(detaching) {
    			if (detaching) detach(div);
    		}
    	};
    }

    function create_fragment$5(ctx) {
    	let promise;
    	let t;
    	let div;
    	let promise_1;
    	let current;

    	let info = {
    		ctx,
    		current: null,
    		token: null,
    		hasCatch: false,
    		pending: create_pending_block_1$1,
    		then: create_then_block_1$1,
    		catch: create_catch_block_1$1,
    		value: 4,
    		blocks: [,,,]
    	};

    	handle_promise(promise = /*post*/ ctx[4], info);

    	let info_1 = {
    		ctx,
    		current: null,
    		token: null,
    		hasCatch: true,
    		pending: create_pending_block$2,
    		then: create_then_block$2,
    		catch: create_catch_block$2,
    		value: 4,
    		error: 13,
    		blocks: [,,,]
    	};

    	handle_promise(promise_1 = /*post*/ ctx[4], info_1);

    	return {
    		c() {
    			info.block.c();
    			t = space();
    			div = element("div");
    			info_1.block.c();
    			attr(div, "class", "post-view svelte-1nxgrob");
    		},
    		m(target, anchor) {
    			info.block.m(target, info.anchor = anchor);
    			info.mount = () => t.parentNode;
    			info.anchor = t;
    			insert(target, t, anchor);
    			insert(target, div, anchor);
    			info_1.block.m(div, info_1.anchor = null);
    			info_1.mount = () => div;
    			info_1.anchor = null;
    			current = true;
    		},
    		p(new_ctx, [dirty]) {
    			ctx = new_ctx;
    			info.ctx = ctx;

    			if (dirty & /*post*/ 16 && promise !== (promise = /*post*/ ctx[4]) && handle_promise(promise, info)) ; else {
    				update_await_block_branch(info, ctx, dirty);
    			}

    			info_1.ctx = ctx;

    			if (dirty & /*post*/ 16 && promise_1 !== (promise_1 = /*post*/ ctx[4]) && handle_promise(promise_1, info_1)) ; else {
    				update_await_block_branch(info_1, ctx, dirty);
    			}
    		},
    		i(local) {
    			if (current) return;
    			transition_in(info.block);
    			transition_in(info_1.block);
    			current = true;
    		},
    		o(local) {
    			for (let i = 0; i < 3; i += 1) {
    				const block = info.blocks[i];
    				transition_out(block);
    			}

    			for (let i = 0; i < 3; i += 1) {
    				const block = info_1.blocks[i];
    				transition_out(block);
    			}

    			current = false;
    		},
    		d(detaching) {
    			info.block.d(detaching);
    			info.token = null;
    			info = null;
    			if (detaching) detach(t);
    			if (detaching) detach(div);
    			info_1.block.d();
    			info_1.token = null;
    			info_1 = null;
    		}
    	};
    }

    const query$3 = '*[slug.current == $slug && _type == $category]{_id, "en_title": en_name, en_title, "ar_title": ar_name, ar_title, en_content, ar_content, "slug":language.current, mainImage, videoLink, posterImage, link, publisherName, "category": _type, participants[]->{en_title, ar_title, "slug": slug.current, "category": _type}}[0]';

    function instance$4($$self, $$props, $$invalidate) {
    	let $isArabic;
    	let $isEnglish;
    	component_subscribe($$self, isArabic, $$value => $$invalidate(2, $isArabic = $$value));
    	component_subscribe($$self, isEnglish, $$value => $$invalidate(3, $isEnglish = $$value));
    	let { slug = "" } = $$props;
    	let { category = "" } = $$props;
    	let { language = "" } = $$props;

    	// *** DOM REFERENCES
    	let imageEl = {};

    	// ** VARIABLES
    	let post = {};

    	let loaded = false;

    	// Set globals
    	globalLanguage.set(language === "ar" ? "arabic" : "english");

    	// *** ON MOUNT
    	onMount(async () => {
    		window.scrollTo(0, 0);
    	});

    	const load_handler = () => $$invalidate(1, loaded = true);

    	function div_binding($$value) {
    		binding_callbacks[$$value ? 'unshift' : 'push'](() => {
    			imageEl = $$value;
    			$$invalidate(0, imageEl);
    		});
    	}

    	$$self.$$set = $$props => {
    		if ('slug' in $$props) $$invalidate(5, slug = $$props.slug);
    		if ('category' in $$props) $$invalidate(6, category = $$props.category);
    		if ('language' in $$props) $$invalidate(7, language = $$props.language);
    	};

    	$$self.$$.update = () => {
    		if ($$self.$$.dirty & /*slug, category*/ 96) {
    			{
    				$$invalidate(4, post = loadSingleData(query$3, { slug, category }));
    			}
    		}

    		if ($$self.$$.dirty & /*category*/ 64) {
    			{
    				activeNavigation.set(category ? category : "");
    			}
    		}
    	};

    	return [
    		imageEl,
    		loaded,
    		$isArabic,
    		$isEnglish,
    		post,
    		slug,
    		category,
    		language,
    		load_handler,
    		div_binding
    	];
    }

    class PostView extends SvelteComponent {
    	constructor(options) {
    		super();
    		init(this, options, instance$4, create_fragment$5, safe_not_equal, { slug: 5, category: 6, language: 7 });
    	}
    }

    /* src\Views\IntroductionView.svelte generated by Svelte v3.58.0 */

    function create_catch_block_1(ctx) {
    	return {
    		c: noop$1,
    		m: noop$1,
    		p: noop$1,
    		i: noop$1,
    		o: noop$1,
    		d: noop$1
    	};
    }

    // (283:23)     <MetaData {post}
    function create_then_block_1(ctx) {
    	let metadata;
    	let current;
    	metadata = new MetaData({ props: { post: /*post*/ ctx[2] } });

    	return {
    		c() {
    			create_component(metadata.$$.fragment);
    		},
    		m(target, anchor) {
    			mount_component(metadata, target, anchor);
    			current = true;
    		},
    		p(ctx, dirty) {
    			const metadata_changes = {};
    			if (dirty & /*post*/ 4) metadata_changes.post = /*post*/ ctx[2];
    			metadata.$set(metadata_changes);
    		},
    		i(local) {
    			if (current) return;
    			transition_in(metadata.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(metadata.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			destroy_component(metadata, detaching);
    		}
    	};
    }

    // (1:0) <script>    // # # # # # # # # # # # # #    //    // Introduction View    //    // # # # # # # # # # # # # #      // *** IMPORT    import { fade }
    function create_pending_block_1(ctx) {
    	return {
    		c: noop$1,
    		m: noop$1,
    		p: noop$1,
    		i: noop$1,
    		o: noop$1,
    		d: noop$1
    	};
    }

    // (308:2) {:catch error}
    function create_catch_block$1(ctx) {
    	let p;
    	let t_value = /*error*/ ctx[5].message + "";
    	let t;

    	return {
    		c() {
    			p = element("p");
    			t = text(t_value);
    			set_style(p, "color", "red");
    		},
    		m(target, anchor) {
    			insert(target, p, anchor);
    			append(p, t);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 4 && t_value !== (t_value = /*error*/ ctx[5].message + "")) set_data(t, t_value);
    		},
    		i: noop$1,
    		o: noop$1,
    		d(detaching) {
    			if (detaching) detach(p);
    		}
    	};
    }

    // (290:2) {:then post}
    function create_then_block$1(ctx) {
    	let div0;
    	let satoshi;
    	let t0;
    	let div3;
    	let div1;
    	let t1;
    	let t2;
    	let div2;
    	let t3;
    	let div3_intro;
    	let current;

    	satoshi = new Satoshi({
    			props: {
    				satoshiIndex: /*post*/ ctx[2].satoshiIndex
    			}
    		});

    	let if_block0 = /*$isEnglish*/ ctx[1] && create_if_block_3$1(ctx);
    	let if_block1 = /*$isArabic*/ ctx[0] && create_if_block_2$1(ctx);
    	let if_block2 = /*$isEnglish*/ ctx[1] && create_if_block_1$2(ctx);
    	let if_block3 = /*$isArabic*/ ctx[0] && create_if_block$2(ctx);

    	return {
    		c() {
    			div0 = element("div");
    			create_component(satoshi.$$.fragment);
    			t0 = space();
    			div3 = element("div");
    			div1 = element("div");
    			if (if_block0) if_block0.c();
    			t1 = space();
    			if (if_block1) if_block1.c();
    			t2 = space();
    			div2 = element("div");
    			if (if_block2) if_block2.c();
    			t3 = space();
    			if (if_block3) if_block3.c();
    			attr(div0, "class", "introduction-view-image svelte-15i7wa6");
    			toggle_class(div0, "arabic", /*$isArabic*/ ctx[0]);
    			attr(div1, "class", "introduction-view-title svelte-15i7wa6");
    			attr(div2, "class", "introduction-view-text-inner svelte-15i7wa6");
    			toggle_class(div2, "arabic", /*$isArabic*/ ctx[0]);
    			attr(div3, "class", "introduction-view-text svelte-15i7wa6");
    			toggle_class(div3, "arabic", /*$isArabic*/ ctx[0]);
    		},
    		m(target, anchor) {
    			insert(target, div0, anchor);
    			mount_component(satoshi, div0, null);
    			insert(target, t0, anchor);
    			insert(target, div3, anchor);
    			append(div3, div1);
    			if (if_block0) if_block0.m(div1, null);
    			append(div1, t1);
    			if (if_block1) if_block1.m(div1, null);
    			append(div3, t2);
    			append(div3, div2);
    			if (if_block2) if_block2.m(div2, null);
    			append(div2, t3);
    			if (if_block3) if_block3.m(div2, null);
    			current = true;
    		},
    		p(ctx, dirty) {
    			const satoshi_changes = {};
    			if (dirty & /*post*/ 4) satoshi_changes.satoshiIndex = /*post*/ ctx[2].satoshiIndex;
    			satoshi.$set(satoshi_changes);

    			if (!current || dirty & /*$isArabic*/ 1) {
    				toggle_class(div0, "arabic", /*$isArabic*/ ctx[0]);
    			}

    			if (/*$isEnglish*/ ctx[1]) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);
    				} else {
    					if_block0 = create_if_block_3$1(ctx);
    					if_block0.c();
    					if_block0.m(div1, t1);
    				}
    			} else if (if_block0) {
    				if_block0.d(1);
    				if_block0 = null;
    			}

    			if (/*$isArabic*/ ctx[0]) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);
    				} else {
    					if_block1 = create_if_block_2$1(ctx);
    					if_block1.c();
    					if_block1.m(div1, null);
    				}
    			} else if (if_block1) {
    				if_block1.d(1);
    				if_block1 = null;
    			}

    			if (/*$isEnglish*/ ctx[1]) {
    				if (if_block2) {
    					if_block2.p(ctx, dirty);
    				} else {
    					if_block2 = create_if_block_1$2(ctx);
    					if_block2.c();
    					if_block2.m(div2, t3);
    				}
    			} else if (if_block2) {
    				if_block2.d(1);
    				if_block2 = null;
    			}

    			if (/*$isArabic*/ ctx[0]) {
    				if (if_block3) {
    					if_block3.p(ctx, dirty);
    				} else {
    					if_block3 = create_if_block$2(ctx);
    					if_block3.c();
    					if_block3.m(div2, null);
    				}
    			} else if (if_block3) {
    				if_block3.d(1);
    				if_block3 = null;
    			}

    			if (!current || dirty & /*$isArabic*/ 1) {
    				toggle_class(div2, "arabic", /*$isArabic*/ ctx[0]);
    			}

    			if (!current || dirty & /*$isArabic*/ 1) {
    				toggle_class(div3, "arabic", /*$isArabic*/ ctx[0]);
    			}
    		},
    		i(local) {
    			if (current) return;
    			transition_in(satoshi.$$.fragment, local);

    			if (!div3_intro) {
    				add_render_callback(() => {
    					div3_intro = create_in_transition(div3, fade, {});
    					div3_intro.start();
    				});
    			}

    			current = true;
    		},
    		o(local) {
    			transition_out(satoshi.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			if (detaching) detach(div0);
    			destroy_component(satoshi);
    			if (detaching) detach(t0);
    			if (detaching) detach(div3);
    			if (if_block0) if_block0.d();
    			if (if_block1) if_block1.d();
    			if (if_block2) if_block2.d();
    			if (if_block3) if_block3.d();
    		}
    	};
    }

    // (296:8) {#if $isEnglish}
    function create_if_block_3$1(ctx) {
    	let t_value = /*post*/ ctx[2].title.english + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 4 && t_value !== (t_value = /*post*/ ctx[2].title.english + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (297:8) {#if $isArabic}
    function create_if_block_2$1(ctx) {
    	let t_value = /*post*/ ctx[2].title.arabic + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 4 && t_value !== (t_value = /*post*/ ctx[2].title.arabic + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (300:8) {#if $isEnglish}
    function create_if_block_1$2(ctx) {
    	let html_tag;
    	let raw_value = renderBlockText(/*post*/ ctx[2].content.english) + "";
    	let html_anchor;

    	return {
    		c() {
    			html_tag = new HtmlTag(false);
    			html_anchor = empty();
    			html_tag.a = html_anchor;
    		},
    		m(target, anchor) {
    			html_tag.m(raw_value, target, anchor);
    			insert(target, html_anchor, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 4 && raw_value !== (raw_value = renderBlockText(/*post*/ ctx[2].content.english) + "")) html_tag.p(raw_value);
    		},
    		d(detaching) {
    			if (detaching) detach(html_anchor);
    			if (detaching) html_tag.d();
    		}
    	};
    }

    // (303:8) {#if $isArabic}
    function create_if_block$2(ctx) {
    	let html_tag;
    	let raw_value = renderBlockText(/*post*/ ctx[2].content.arabic) + "";
    	let html_anchor;

    	return {
    		c() {
    			html_tag = new HtmlTag(false);
    			html_anchor = empty();
    			html_tag.a = html_anchor;
    		},
    		m(target, anchor) {
    			html_tag.m(raw_value, target, anchor);
    			insert(target, html_anchor, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*post*/ 4 && raw_value !== (raw_value = renderBlockText(/*post*/ ctx[2].content.arabic) + "")) html_tag.p(raw_value);
    		},
    		d(detaching) {
    			if (detaching) detach(html_anchor);
    			if (detaching) html_tag.d();
    		}
    	};
    }

    // (288:15)       <div />    {:then post}
    function create_pending_block$1(ctx) {
    	let div;

    	return {
    		c() {
    			div = element("div");
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);
    		},
    		p: noop$1,
    		i: noop$1,
    		o: noop$1,
    		d(detaching) {
    			if (detaching) detach(div);
    		}
    	};
    }

    function create_fragment$4(ctx) {
    	let promise;
    	let t;
    	let div;
    	let promise_1;
    	let current;

    	let info = {
    		ctx,
    		current: null,
    		token: null,
    		hasCatch: false,
    		pending: create_pending_block_1,
    		then: create_then_block_1,
    		catch: create_catch_block_1,
    		value: 2,
    		blocks: [,,,]
    	};

    	handle_promise(promise = /*post*/ ctx[2], info);

    	let info_1 = {
    		ctx,
    		current: null,
    		token: null,
    		hasCatch: true,
    		pending: create_pending_block$1,
    		then: create_then_block$1,
    		catch: create_catch_block$1,
    		value: 2,
    		error: 5,
    		blocks: [,,,]
    	};

    	handle_promise(promise_1 = /*post*/ ctx[2], info_1);

    	return {
    		c() {
    			info.block.c();
    			t = space();
    			div = element("div");
    			info_1.block.c();
    			attr(div, "class", "introduction-view svelte-15i7wa6");
    		},
    		m(target, anchor) {
    			info.block.m(target, info.anchor = anchor);
    			info.mount = () => t.parentNode;
    			info.anchor = t;
    			insert(target, t, anchor);
    			insert(target, div, anchor);
    			info_1.block.m(div, info_1.anchor = null);
    			info_1.mount = () => div;
    			info_1.anchor = null;
    			current = true;
    		},
    		p(new_ctx, [dirty]) {
    			ctx = new_ctx;
    			info.ctx = ctx;

    			if (dirty & /*post*/ 4 && promise !== (promise = /*post*/ ctx[2]) && handle_promise(promise, info)) ; else {
    				update_await_block_branch(info, ctx, dirty);
    			}

    			info_1.ctx = ctx;

    			if (dirty & /*post*/ 4 && promise_1 !== (promise_1 = /*post*/ ctx[2]) && handle_promise(promise_1, info_1)) ; else {
    				update_await_block_branch(info_1, ctx, dirty);
    			}
    		},
    		i(local) {
    			if (current) return;
    			transition_in(info.block);
    			transition_in(info_1.block);
    			current = true;
    		},
    		o(local) {
    			for (let i = 0; i < 3; i += 1) {
    				const block = info.blocks[i];
    				transition_out(block);
    			}

    			for (let i = 0; i < 3; i += 1) {
    				const block = info_1.blocks[i];
    				transition_out(block);
    			}

    			current = false;
    		},
    		d(detaching) {
    			info.block.d(detaching);
    			info.token = null;
    			info = null;
    			if (detaching) detach(t);
    			if (detaching) detach(div);
    			info_1.block.d();
    			info_1.token = null;
    			info_1 = null;
    		}
    	};
    }

    const query$2 = '*[slug.current == $slug && _type == "categoryIntroduction"]{satoshiIndex, en_title, ar_title, en_content, ar_content, "slug": slug.current, mainImage, "category": _type}[0]';

    function instance$3($$self, $$props, $$invalidate) {
    	let $isArabic;
    	let $isEnglish;
    	component_subscribe($$self, isArabic, $$value => $$invalidate(0, $isArabic = $$value));
    	component_subscribe($$self, isEnglish, $$value => $$invalidate(1, $isEnglish = $$value));
    	let { slug = "" } = $$props;
    	let { language = "" } = $$props;

    	// ** VARIABLES
    	let post = {};

    	// Set globals
    	globalLanguage.set(language === "ar" ? "arabic" : "english");

    	$$self.$$set = $$props => {
    		if ('slug' in $$props) $$invalidate(3, slug = $$props.slug);
    		if ('language' in $$props) $$invalidate(4, language = $$props.language);
    	};

    	$$self.$$.update = () => {
    		if ($$self.$$.dirty & /*slug*/ 8) {
    			{
    				$$invalidate(2, post = loadSingleData(query$2, { slug }));
    			}
    		}

    		if ($$self.$$.dirty & /*slug*/ 8) {
    			{
    				activeNavigation.set(slug ? slug : "");
    			}
    		}
    	};

    	return [$isArabic, $isEnglish, post, slug, language];
    }

    class IntroductionView extends SvelteComponent {
    	constructor(options) {
    		super();
    		init(this, options, instance$3, create_fragment$4, safe_not_equal, { slug: 3, language: 4 });
    	}
    }

    /* src\Components\ProgrammeSection.svelte generated by Svelte v3.58.0 */

    function get_each_context(ctx, list, i) {
    	const child_ctx = ctx.slice();
    	child_ctx[9] = list[i];
    	child_ctx[11] = i;
    	return child_ctx;
    }

    function get_each_context_1(ctx, list, i) {
    	const child_ctx = ctx.slice();
    	child_ctx[12] = list[i];
    	return child_ctx;
    }

    function get_each_context_2(ctx, list, i) {
    	const child_ctx = ctx.slice();
    	child_ctx[15] = list[i];
    	return child_ctx;
    }

    // (246:6) {:else}
    function create_else_block(ctx) {
    	let svg;
    	let polyline;
    	let svg_intro;

    	return {
    		c() {
    			svg = svg_element("svg");
    			polyline = svg_element("polyline");
    			attr(polyline, "points", "6 9 12 15 18 9");
    			attr(svg, "xmlns", "http://www.w3.org/2000/svg");
    			attr(svg, "width", "50");
    			attr(svg, "height", "50");
    			attr(svg, "viewBox", "0 0 24 24");
    			attr(svg, "fill", "none");
    			attr(svg, "stroke", "currentColor");
    			attr(svg, "stroke-width", "1");
    			attr(svg, "class", "feather feather-chevron-down svelte-8leps8");
    		},
    		m(target, anchor) {
    			insert(target, svg, anchor);
    			append(svg, polyline);
    		},
    		i(local) {
    			if (!svg_intro) {
    				add_render_callback(() => {
    					svg_intro = create_in_transition(svg, scale, { duration: 250 });
    					svg_intro.start();
    				});
    			}
    		},
    		o: noop$1,
    		d(detaching) {
    			if (detaching) detach(svg);
    		}
    	};
    }

    // (232:6) {#if open}
    function create_if_block_12(ctx) {
    	let svg;
    	let line0;
    	let line1;
    	let svg_intro;

    	return {
    		c() {
    			svg = svg_element("svg");
    			line0 = svg_element("line");
    			line1 = svg_element("line");
    			attr(line0, "x1", "18");
    			attr(line0, "y1", "6");
    			attr(line0, "x2", "6");
    			attr(line0, "y2", "18");
    			attr(line1, "x1", "6");
    			attr(line1, "y1", "6");
    			attr(line1, "x2", "18");
    			attr(line1, "y2", "18");
    			attr(svg, "xmlns", "http://www.w3.org/2000/svg");
    			attr(svg, "width", "50");
    			attr(svg, "height", "50");
    			attr(svg, "viewBox", "0 0 24 24");
    			attr(svg, "fill", "none");
    			attr(svg, "stroke", "currentColor");
    			attr(svg, "stroke-width", "1");
    			attr(svg, "class", "feather feather-x svelte-8leps8");
    		},
    		m(target, anchor) {
    			insert(target, svg, anchor);
    			append(svg, line0);
    			append(svg, line1);
    		},
    		i(local) {
    			if (!svg_intro) {
    				add_render_callback(() => {
    					svg_intro = create_in_transition(svg, scale, { duration: 250 });
    					svg_intro.start();
    				});
    			}
    		},
    		o: noop$1,
    		d(detaching) {
    			if (detaching) detach(svg);
    		}
    	};
    }

    // (262:2) {#if open}
    function create_if_block$1(ctx) {
    	let div;
    	let each_value = /*events*/ ctx[0];
    	let each_blocks = [];

    	for (let i = 0; i < each_value.length; i += 1) {
    		each_blocks[i] = create_each_block(get_each_context(ctx, each_value, i));
    	}

    	return {
    		c() {
    			div = element("div");

    			for (let i = 0; i < each_blocks.length; i += 1) {
    				each_blocks[i].c();
    			}

    			attr(div, "class", "programme-event-body");
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);

    			for (let i = 0; i < each_blocks.length; i += 1) {
    				if (each_blocks[i]) {
    					each_blocks[i].m(div, null);
    				}
    			}
    		},
    		p(ctx, dirty) {
    			if (dirty & /*getEventColor, events, renderBlockText, $isArabic, has, $isEnglish, isEmpty, $languagePrefix*/ 121) {
    				each_value = /*events*/ ctx[0];
    				let i;

    				for (i = 0; i < each_value.length; i += 1) {
    					const child_ctx = get_each_context(ctx, each_value, i);

    					if (each_blocks[i]) {
    						each_blocks[i].p(child_ctx, dirty);
    						transition_in(each_blocks[i], 1);
    					} else {
    						each_blocks[i] = create_each_block(child_ctx);
    						each_blocks[i].c();
    						transition_in(each_blocks[i], 1);
    						each_blocks[i].m(div, null);
    					}
    				}

    				for (; i < each_blocks.length; i += 1) {
    					each_blocks[i].d(1);
    				}

    				each_blocks.length = each_value.length;
    			}
    		},
    		i(local) {
    			for (let i = 0; i < each_value.length; i += 1) {
    				transition_in(each_blocks[i]);
    			}
    		},
    		o: noop$1,
    		d(detaching) {
    			if (detaching) detach(div);
    			destroy_each(each_blocks, detaching);
    		}
    	};
    }

    // (271:10) {#if !isEmpty(event.event.performers)}
    function create_if_block_9(ctx) {
    	let div;
    	let each_value_2 = /*event*/ ctx[9].event.performers;
    	let each_blocks = [];

    	for (let i = 0; i < each_value_2.length; i += 1) {
    		each_blocks[i] = create_each_block_2(get_each_context_2(ctx, each_value_2, i));
    	}

    	return {
    		c() {
    			div = element("div");

    			for (let i = 0; i < each_blocks.length; i += 1) {
    				each_blocks[i].c();
    			}

    			attr(div, "class", "programme-event-text svelte-8leps8");
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);

    			for (let i = 0; i < each_blocks.length; i += 1) {
    				if (each_blocks[i]) {
    					each_blocks[i].m(div, null);
    				}
    			}
    		},
    		p(ctx, dirty) {
    			if (dirty & /*$languagePrefix, events, $isArabic, $isEnglish*/ 57) {
    				each_value_2 = /*event*/ ctx[9].event.performers;
    				let i;

    				for (i = 0; i < each_value_2.length; i += 1) {
    					const child_ctx = get_each_context_2(ctx, each_value_2, i);

    					if (each_blocks[i]) {
    						each_blocks[i].p(child_ctx, dirty);
    					} else {
    						each_blocks[i] = create_each_block_2(child_ctx);
    						each_blocks[i].c();
    						each_blocks[i].m(div, null);
    					}
    				}

    				for (; i < each_blocks.length; i += 1) {
    					each_blocks[i].d(1);
    				}

    				each_blocks.length = each_value_2.length;
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(div);
    			destroy_each(each_blocks, detaching);
    		}
    	};
    }

    // (276:18) {#if $isEnglish}
    function create_if_block_11(ctx) {
    	let t_value = /*performer*/ ctx[15].en_title + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*events*/ 1 && t_value !== (t_value = /*performer*/ ctx[15].en_title + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (277:18) {#if $isArabic}
    function create_if_block_10(ctx) {
    	let t_value = /*performer*/ ctx[15].ar_title + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*events*/ 1 && t_value !== (t_value = /*performer*/ ctx[15].ar_title + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (273:14) {#each event.event.performers as performer}
    function create_each_block_2(ctx) {
    	let a;
    	let t0;
    	let t1;
    	let a_href_value;
    	let if_block0 = /*$isEnglish*/ ctx[4] && create_if_block_11(ctx);
    	let if_block1 = /*$isArabic*/ ctx[5] && create_if_block_10(ctx);

    	return {
    		c() {
    			a = element("a");
    			if (if_block0) if_block0.c();
    			t0 = space();
    			if (if_block1) if_block1.c();
    			t1 = space();
    			attr(a, "href", a_href_value = "/" + /*$languagePrefix*/ ctx[3] + "/" + /*performer*/ ctx[15].category + "/" + /*performer*/ ctx[15].slug);
    			attr(a, "class", "svelte-8leps8");
    		},
    		m(target, anchor) {
    			insert(target, a, anchor);
    			if (if_block0) if_block0.m(a, null);
    			append(a, t0);
    			if (if_block1) if_block1.m(a, null);
    			append(a, t1);
    		},
    		p(ctx, dirty) {
    			if (/*$isEnglish*/ ctx[4]) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);
    				} else {
    					if_block0 = create_if_block_11(ctx);
    					if_block0.c();
    					if_block0.m(a, t0);
    				}
    			} else if (if_block0) {
    				if_block0.d(1);
    				if_block0 = null;
    			}

    			if (/*$isArabic*/ ctx[5]) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);
    				} else {
    					if_block1 = create_if_block_10(ctx);
    					if_block1.c();
    					if_block1.m(a, t1);
    				}
    			} else if (if_block1) {
    				if_block1.d(1);
    				if_block1 = null;
    			}

    			if (dirty & /*$languagePrefix, events*/ 9 && a_href_value !== (a_href_value = "/" + /*$languagePrefix*/ ctx[3] + "/" + /*performer*/ ctx[15].category + "/" + /*performer*/ ctx[15].slug)) {
    				attr(a, "href", a_href_value);
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(a);
    			if (if_block0) if_block0.d();
    			if (if_block1) if_block1.d();
    		}
    	};
    }

    // (282:10) {#if !isEmpty(event.event.discussions)}
    function create_if_block_6(ctx) {
    	let div;
    	let each_value_1 = /*event*/ ctx[9].event.discussions;
    	let each_blocks = [];

    	for (let i = 0; i < each_value_1.length; i += 1) {
    		each_blocks[i] = create_each_block_1(get_each_context_1(ctx, each_value_1, i));
    	}

    	return {
    		c() {
    			div = element("div");

    			for (let i = 0; i < each_blocks.length; i += 1) {
    				each_blocks[i].c();
    			}

    			attr(div, "class", "programme-event-text svelte-8leps8");
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);

    			for (let i = 0; i < each_blocks.length; i += 1) {
    				if (each_blocks[i]) {
    					each_blocks[i].m(div, null);
    				}
    			}
    		},
    		p(ctx, dirty) {
    			if (dirty & /*$languagePrefix, events, $isArabic, $isEnglish*/ 57) {
    				each_value_1 = /*event*/ ctx[9].event.discussions;
    				let i;

    				for (i = 0; i < each_value_1.length; i += 1) {
    					const child_ctx = get_each_context_1(ctx, each_value_1, i);

    					if (each_blocks[i]) {
    						each_blocks[i].p(child_ctx, dirty);
    					} else {
    						each_blocks[i] = create_each_block_1(child_ctx);
    						each_blocks[i].c();
    						each_blocks[i].m(div, null);
    					}
    				}

    				for (; i < each_blocks.length; i += 1) {
    					each_blocks[i].d(1);
    				}

    				each_blocks.length = each_value_1.length;
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(div);
    			destroy_each(each_blocks, detaching);
    		}
    	};
    }

    // (287:18) {#if $isEnglish}
    function create_if_block_8(ctx) {
    	let t_value = /*discussion*/ ctx[12].en_title + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*events*/ 1 && t_value !== (t_value = /*discussion*/ ctx[12].en_title + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (288:18) {#if $isArabic}
    function create_if_block_7(ctx) {
    	let t_value = /*discussion*/ ctx[12].ar_title + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*events*/ 1 && t_value !== (t_value = /*discussion*/ ctx[12].ar_title + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (284:14) {#each event.event.discussions as discussion}
    function create_each_block_1(ctx) {
    	let a;
    	let t0;
    	let t1;
    	let a_href_value;
    	let if_block0 = /*$isEnglish*/ ctx[4] && create_if_block_8(ctx);
    	let if_block1 = /*$isArabic*/ ctx[5] && create_if_block_7(ctx);

    	return {
    		c() {
    			a = element("a");
    			if (if_block0) if_block0.c();
    			t0 = space();
    			if (if_block1) if_block1.c();
    			t1 = space();
    			attr(a, "href", a_href_value = "/" + /*$languagePrefix*/ ctx[3] + "/" + /*discussion*/ ctx[12].category + "/" + /*discussion*/ ctx[12].slug);
    			attr(a, "class", "svelte-8leps8");
    		},
    		m(target, anchor) {
    			insert(target, a, anchor);
    			if (if_block0) if_block0.m(a, null);
    			append(a, t0);
    			if (if_block1) if_block1.m(a, null);
    			append(a, t1);
    		},
    		p(ctx, dirty) {
    			if (/*$isEnglish*/ ctx[4]) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);
    				} else {
    					if_block0 = create_if_block_8(ctx);
    					if_block0.c();
    					if_block0.m(a, t0);
    				}
    			} else if (if_block0) {
    				if_block0.d(1);
    				if_block0 = null;
    			}

    			if (/*$isArabic*/ ctx[5]) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);
    				} else {
    					if_block1 = create_if_block_7(ctx);
    					if_block1.c();
    					if_block1.m(a, t1);
    				}
    			} else if (if_block1) {
    				if_block1.d(1);
    				if_block1 = null;
    			}

    			if (dirty & /*$languagePrefix, events*/ 9 && a_href_value !== (a_href_value = "/" + /*$languagePrefix*/ ctx[3] + "/" + /*discussion*/ ctx[12].category + "/" + /*discussion*/ ctx[12].slug)) {
    				attr(a, "href", a_href_value);
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(a);
    			if (if_block0) if_block0.d();
    			if (if_block1) if_block1.d();
    		}
    	};
    }

    // (293:10) {#if isEmpty(event.event.performers) && isEmpty(event.event.discussions)}
    function create_if_block_3(ctx) {
    	let div;
    	let t;
    	let if_block0 = /*$isEnglish*/ ctx[4] && create_if_block_5(ctx);
    	let if_block1 = /*$isArabic*/ ctx[5] && create_if_block_4(ctx);

    	return {
    		c() {
    			div = element("div");
    			if (if_block0) if_block0.c();
    			t = space();
    			if (if_block1) if_block1.c();
    			attr(div, "class", "programme-event-title svelte-8leps8");
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);
    			if (if_block0) if_block0.m(div, null);
    			append(div, t);
    			if (if_block1) if_block1.m(div, null);
    		},
    		p(ctx, dirty) {
    			if (/*$isEnglish*/ ctx[4]) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);
    				} else {
    					if_block0 = create_if_block_5(ctx);
    					if_block0.c();
    					if_block0.m(div, t);
    				}
    			} else if (if_block0) {
    				if_block0.d(1);
    				if_block0 = null;
    			}

    			if (/*$isArabic*/ ctx[5]) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);
    				} else {
    					if_block1 = create_if_block_4(ctx);
    					if_block1.c();
    					if_block1.m(div, null);
    				}
    			} else if (if_block1) {
    				if_block1.d(1);
    				if_block1 = null;
    			}
    		},
    		d(detaching) {
    			if (detaching) detach(div);
    			if (if_block0) if_block0.d();
    			if (if_block1) if_block1.d();
    		}
    	};
    }

    // (295:14) {#if $isEnglish}
    function create_if_block_5(ctx) {
    	let t_value = /*event*/ ctx[9].title.english + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*events*/ 1 && t_value !== (t_value = /*event*/ ctx[9].title.english + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (296:14) {#if $isArabic}
    function create_if_block_4(ctx) {
    	let t_value = /*event*/ ctx[9].title.arabic + "";
    	let t;

    	return {
    		c() {
    			t = text(t_value);
    		},
    		m(target, anchor) {
    			insert(target, t, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*events*/ 1 && t_value !== (t_value = /*event*/ ctx[9].title.arabic + "")) set_data(t, t_value);
    		},
    		d(detaching) {
    			if (detaching) detach(t);
    		}
    	};
    }

    // (300:12) {#if $isEnglish && has(event, 'content.english', false)}
    function create_if_block_2(ctx) {
    	let html_tag;
    	let raw_value = renderBlockText(/*event*/ ctx[9].content.english) + "";
    	let html_anchor;

    	return {
    		c() {
    			html_tag = new HtmlTag(false);
    			html_anchor = empty();
    			html_tag.a = html_anchor;
    		},
    		m(target, anchor) {
    			html_tag.m(raw_value, target, anchor);
    			insert(target, html_anchor, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*events*/ 1 && raw_value !== (raw_value = renderBlockText(/*event*/ ctx[9].content.english) + "")) html_tag.p(raw_value);
    		},
    		d(detaching) {
    			if (detaching) detach(html_anchor);
    			if (detaching) html_tag.d();
    		}
    	};
    }

    // (303:12) {#if $isArabic && has(event, 'content.arabic', false)}
    function create_if_block_1$1(ctx) {
    	let html_tag;
    	let raw_value = renderBlockText(/*event*/ ctx[9].content.arabic) + "";
    	let html_anchor;

    	return {
    		c() {
    			html_tag = new HtmlTag(false);
    			html_anchor = empty();
    			html_tag.a = html_anchor;
    		},
    		m(target, anchor) {
    			html_tag.m(raw_value, target, anchor);
    			insert(target, html_anchor, anchor);
    		},
    		p(ctx, dirty) {
    			if (dirty & /*events*/ 1 && raw_value !== (raw_value = renderBlockText(/*event*/ ctx[9].content.arabic) + "")) html_tag.p(raw_value);
    		},
    		d(detaching) {
    			if (detaching) detach(html_anchor);
    			if (detaching) html_tag.d();
    		}
    	};
    }

    // (264:6) {#each events as event, i}
    function create_each_block(ctx) {
    	let div2;
    	let div0;
    	let t0_value = /*event*/ ctx[9].event.startTime + "";
    	let t0;
    	let t1;
    	let show_if_4 = !isEmpty_1(/*event*/ ctx[9].event.performers);
    	let t2;
    	let show_if_3 = !isEmpty_1(/*event*/ ctx[9].event.discussions);
    	let t3;
    	let show_if_2 = isEmpty_1(/*event*/ ctx[9].event.performers) && isEmpty_1(/*event*/ ctx[9].event.discussions);
    	let t4;
    	let div1;
    	let show_if_1 = /*$isEnglish*/ ctx[4] && has_1(/*event*/ ctx[9], 'content.english');
    	let t5;
    	let show_if = /*$isArabic*/ ctx[5] && has_1(/*event*/ ctx[9], 'content.arabic');
    	let t6;
    	let div2_class_value;
    	let div2_intro;
    	let mounted;
    	let dispose;
    	let if_block0 = show_if_4 && create_if_block_9(ctx);
    	let if_block1 = show_if_3 && create_if_block_6(ctx);
    	let if_block2 = show_if_2 && create_if_block_3(ctx);
    	let if_block3 = show_if_1 && create_if_block_2(ctx);
    	let if_block4 = show_if && create_if_block_1$1(ctx);

    	return {
    		c() {
    			div2 = element("div");
    			div0 = element("div");
    			t0 = text(t0_value);
    			t1 = space();
    			if (if_block0) if_block0.c();
    			t2 = space();
    			if (if_block1) if_block1.c();
    			t3 = space();
    			if (if_block2) if_block2.c();
    			t4 = space();
    			div1 = element("div");
    			if (if_block3) if_block3.c();
    			t5 = space();
    			if (if_block4) if_block4.c();
    			t6 = space();
    			attr(div0, "class", "programme-event-date");
    			attr(div1, "class", "programme-event-text svelte-8leps8");
    			attr(div2, "class", div2_class_value = "programme-event " + /*getEventColor*/ ctx[6](/*event*/ ctx[9].event.type) + " " + /*event*/ ctx[9].event.type + " svelte-8leps8");
    		},
    		m(target, anchor) {
    			insert(target, div2, anchor);
    			append(div2, div0);
    			append(div0, t0);
    			append(div2, t1);
    			if (if_block0) if_block0.m(div2, null);
    			append(div2, t2);
    			if (if_block1) if_block1.m(div2, null);
    			append(div2, t3);
    			if (if_block2) if_block2.m(div2, null);
    			append(div2, t4);
    			append(div2, div1);
    			if (if_block3) if_block3.m(div1, null);
    			append(div1, t5);
    			if (if_block4) if_block4.m(div1, null);
    			append(div2, t6);

    			if (!mounted) {
    				dispose = action_destroyer(links.call(null, div2));
    				mounted = true;
    			}
    		},
    		p(ctx, dirty) {
    			if (dirty & /*events*/ 1 && t0_value !== (t0_value = /*event*/ ctx[9].event.startTime + "")) set_data(t0, t0_value);
    			if (dirty & /*events*/ 1) show_if_4 = !isEmpty_1(/*event*/ ctx[9].event.performers);

    			if (show_if_4) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);
    				} else {
    					if_block0 = create_if_block_9(ctx);
    					if_block0.c();
    					if_block0.m(div2, t2);
    				}
    			} else if (if_block0) {
    				if_block0.d(1);
    				if_block0 = null;
    			}

    			if (dirty & /*events*/ 1) show_if_3 = !isEmpty_1(/*event*/ ctx[9].event.discussions);

    			if (show_if_3) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);
    				} else {
    					if_block1 = create_if_block_6(ctx);
    					if_block1.c();
    					if_block1.m(div2, t3);
    				}
    			} else if (if_block1) {
    				if_block1.d(1);
    				if_block1 = null;
    			}

    			if (dirty & /*events*/ 1) show_if_2 = isEmpty_1(/*event*/ ctx[9].event.performers) && isEmpty_1(/*event*/ ctx[9].event.discussions);

    			if (show_if_2) {
    				if (if_block2) {
    					if_block2.p(ctx, dirty);
    				} else {
    					if_block2 = create_if_block_3(ctx);
    					if_block2.c();
    					if_block2.m(div2, t4);
    				}
    			} else if (if_block2) {
    				if_block2.d(1);
    				if_block2 = null;
    			}

    			if (dirty & /*$isEnglish, events*/ 17) show_if_1 = /*$isEnglish*/ ctx[4] && has_1(/*event*/ ctx[9], 'content.english');

    			if (show_if_1) {
    				if (if_block3) {
    					if_block3.p(ctx, dirty);
    				} else {
    					if_block3 = create_if_block_2(ctx);
    					if_block3.c();
    					if_block3.m(div1, t5);
    				}
    			} else if (if_block3) {
    				if_block3.d(1);
    				if_block3 = null;
    			}

    			if (dirty & /*$isArabic, events*/ 33) show_if = /*$isArabic*/ ctx[5] && has_1(/*event*/ ctx[9], 'content.arabic');

    			if (show_if) {
    				if (if_block4) {
    					if_block4.p(ctx, dirty);
    				} else {
    					if_block4 = create_if_block_1$1(ctx);
    					if_block4.c();
    					if_block4.m(div1, null);
    				}
    			} else if (if_block4) {
    				if_block4.d(1);
    				if_block4 = null;
    			}

    			if (dirty & /*events*/ 1 && div2_class_value !== (div2_class_value = "programme-event " + /*getEventColor*/ ctx[6](/*event*/ ctx[9].event.type) + " " + /*event*/ ctx[9].event.type + " svelte-8leps8")) {
    				attr(div2, "class", div2_class_value);
    			}
    		},
    		i(local) {
    			if (!div2_intro) {
    				add_render_callback(() => {
    					div2_intro = create_in_transition(div2, fade, {
    						duration: 100,
    						delay: 75 * (/*i*/ ctx[11] + 1)
    					});

    					div2_intro.start();
    				});
    			}
    		},
    		o: noop$1,
    		d(detaching) {
    			if (detaching) detach(div2);
    			if (if_block0) if_block0.d();
    			if (if_block1) if_block1.d();
    			if (if_block2) if_block2.d();
    			if (if_block3) if_block3.d();
    			if (if_block4) if_block4.d();
    			mounted = false;
    			dispose();
    		}
    	};
    }

    // (224:0) <Router>
    function create_default_slot$1(ctx) {
    	let div2;
    	let div0;
    	let t0;
    	let t1;
    	let div1;
    	let t2;
    	let if_block1_anchor;
    	let mounted;
    	let dispose;

    	function select_block_type(ctx, dirty) {
    		if (/*open*/ ctx[2]) return create_if_block_12;
    		return create_else_block;
    	}

    	let current_block_type = select_block_type(ctx);
    	let if_block0 = current_block_type(ctx);
    	let if_block1 = /*open*/ ctx[2] && create_if_block$1(ctx);

    	return {
    		c() {
    			div2 = element("div");
    			div0 = element("div");
    			t0 = text(/*date*/ ctx[1]);
    			t1 = space();
    			div1 = element("div");
    			if_block0.c();
    			t2 = space();
    			if (if_block1) if_block1.c();
    			if_block1_anchor = empty();
    			attr(div0, "class", "programme-event-header-date svelte-8leps8");
    			attr(div1, "class", "programme-event-open svelte-8leps8");
    			attr(div2, "class", "programme-event top-date svelte-8leps8");
    		},
    		m(target, anchor) {
    			insert(target, div2, anchor);
    			append(div2, div0);
    			append(div0, t0);
    			append(div2, t1);
    			append(div2, div1);
    			if_block0.m(div1, null);
    			insert(target, t2, anchor);
    			if (if_block1) if_block1.m(target, anchor);
    			insert(target, if_block1_anchor, anchor);

    			if (!mounted) {
    				dispose = listen$1(div2, "click", /*click_handler*/ ctx[7]);
    				mounted = true;
    			}
    		},
    		p(ctx, dirty) {
    			if (dirty & /*date*/ 2) set_data(t0, /*date*/ ctx[1]);

    			if (current_block_type !== (current_block_type = select_block_type(ctx))) {
    				if_block0.d(1);
    				if_block0 = current_block_type(ctx);

    				if (if_block0) {
    					if_block0.c();
    					transition_in(if_block0, 1);
    					if_block0.m(div1, null);
    				}
    			}

    			if (/*open*/ ctx[2]) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);

    					if (dirty & /*open*/ 4) {
    						transition_in(if_block1, 1);
    					}
    				} else {
    					if_block1 = create_if_block$1(ctx);
    					if_block1.c();
    					transition_in(if_block1, 1);
    					if_block1.m(if_block1_anchor.parentNode, if_block1_anchor);
    				}
    			} else if (if_block1) {
    				if_block1.d(1);
    				if_block1 = null;
    			}
    		},
    		i(local) {
    			transition_in(if_block0);
    			transition_in(if_block1);
    		},
    		o: noop$1,
    		d(detaching) {
    			if (detaching) detach(div2);
    			if_block0.d();
    			if (detaching) detach(t2);
    			if (if_block1) if_block1.d(detaching);
    			if (detaching) detach(if_block1_anchor);
    			mounted = false;
    			dispose();
    		}
    	};
    }

    function create_fragment$3(ctx) {
    	let router;
    	let current;

    	router = new Router({
    			props: {
    				$$slots: { default: [create_default_slot$1] },
    				$$scope: { ctx }
    			}
    		});

    	return {
    		c() {
    			create_component(router.$$.fragment);
    		},
    		m(target, anchor) {
    			mount_component(router, target, anchor);
    			current = true;
    		},
    		p(ctx, [dirty]) {
    			const router_changes = {};

    			if (dirty & /*$$scope, events, $isArabic, $isEnglish, $languagePrefix, open, date*/ 262207) {
    				router_changes.$$scope = { dirty, ctx };
    			}

    			router.$set(router_changes);
    		},
    		i(local) {
    			if (current) return;
    			transition_in(router.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(router.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			destroy_component(router, detaching);
    		}
    	};
    }

    function instance$2($$self, $$props, $$invalidate) {
    	let $categoryList;
    	let $languagePrefix;
    	let $isEnglish;
    	let $isArabic;
    	component_subscribe($$self, categoryList, $$value => $$invalidate(8, $categoryList = $$value));
    	component_subscribe($$self, languagePrefix, $$value => $$invalidate(3, $languagePrefix = $$value));
    	component_subscribe($$self, isEnglish, $$value => $$invalidate(4, $isEnglish = $$value));
    	component_subscribe($$self, isArabic, $$value => $$invalidate(5, $isArabic = $$value));
    	let { events = [] } = $$props;
    	let { date = "" } = $$props;

    	// *** VARIABLES
    	let open = false;

    	const getEventColor = type => get_1($categoryList.find(c => c.categorySlug === type), "color", "");

    	const click_handler = e => {
    		$$invalidate(2, open = !open);
    	};

    	$$self.$$set = $$props => {
    		if ('events' in $$props) $$invalidate(0, events = $$props.events);
    		if ('date' in $$props) $$invalidate(1, date = $$props.date);
    	};

    	return [
    		events,
    		date,
    		open,
    		$languagePrefix,
    		$isEnglish,
    		$isArabic,
    		getEventColor,
    		click_handler
    	];
    }

    class ProgrammeSection extends SvelteComponent {
    	constructor(options) {
    		super();
    		init(this, options, instance$2, create_fragment$3, safe_not_equal, { events: 0, date: 1 });
    	}
    }

    /* src\Views\ProgrammeView.svelte generated by Svelte v3.58.0 */

    function create_catch_block(ctx) {
    	let p;
    	let t_value = /*error*/ ctx[6].message + "";
    	let t;

    	return {
    		c() {
    			p = element("p");
    			t = text(t_value);
    			set_style(p, "color", "red");
    		},
    		m(target, anchor) {
    			insert(target, p, anchor);
    			append(p, t);
    		},
    		p: noop$1,
    		i: noop$1,
    		o: noop$1,
    		d(detaching) {
    			if (detaching) detach(p);
    		}
    	};
    }

    // (55:0) {:then programme}
    function create_then_block(ctx) {
    	let metadata;
    	let t0;
    	let div3;
    	let div1;
    	let div0;
    	let t1;
    	let div1_intro;
    	let t2;
    	let div2;
    	let programmesection0;
    	let t3;
    	let programmesection1;
    	let t4;
    	let programmesection2;
    	let t5;
    	let programmesection3;
    	let current;

    	metadata = new MetaData({
    			props: { post: /*programme*/ ctx[2].introduction }
    		});

    	let if_block0 = /*$isEnglish*/ ctx[1] && create_if_block_1(ctx);
    	let if_block1 = /*$isArabic*/ ctx[0] && create_if_block(ctx);

    	programmesection0 = new ProgrammeSection({
    			props: {
    				date: "Saturday, November 9th",
    				events: /*programme*/ ctx[2].events["9"]
    			}
    		});

    	programmesection1 = new ProgrammeSection({
    			props: {
    				date: "Sunday, November 10th",
    				events: /*programme*/ ctx[2].events["10"]
    			}
    		});

    	programmesection2 = new ProgrammeSection({
    			props: {
    				date: "Monday, November 11th",
    				events: /*programme*/ ctx[2].events["11"]
    			}
    		});

    	programmesection3 = new ProgrammeSection({
    			props: {
    				date: "Tuesday, November 12th",
    				events: /*programme*/ ctx[2].events["12"]
    			}
    		});

    	return {
    		c() {
    			create_component(metadata.$$.fragment);
    			t0 = space();
    			div3 = element("div");
    			div1 = element("div");
    			div0 = element("div");
    			if (if_block0) if_block0.c();
    			t1 = space();
    			if (if_block1) if_block1.c();
    			t2 = space();
    			div2 = element("div");
    			create_component(programmesection0.$$.fragment);
    			t3 = space();
    			create_component(programmesection1.$$.fragment);
    			t4 = space();
    			create_component(programmesection2.$$.fragment);
    			t5 = space();
    			create_component(programmesection3.$$.fragment);
    			attr(div0, "class", "programme-text-inner svelte-1ywja8k");
    			toggle_class(div0, "arabic", /*$isArabic*/ ctx[0]);
    			attr(div1, "class", "programme-text svelte-1ywja8k");
    			toggle_class(div1, "arabic", /*$isArabic*/ ctx[0]);
    			attr(div2, "class", "programme-calendar svelte-1ywja8k");
    			toggle_class(div2, "arabic", /*$isArabic*/ ctx[0]);
    			attr(div3, "class", "programme svelte-1ywja8k");
    		},
    		m(target, anchor) {
    			mount_component(metadata, target, anchor);
    			insert(target, t0, anchor);
    			insert(target, div3, anchor);
    			append(div3, div1);
    			append(div1, div0);
    			if (if_block0) if_block0.m(div0, null);
    			append(div0, t1);
    			if (if_block1) if_block1.m(div0, null);
    			append(div3, t2);
    			append(div3, div2);
    			mount_component(programmesection0, div2, null);
    			append(div2, t3);
    			mount_component(programmesection1, div2, null);
    			append(div2, t4);
    			mount_component(programmesection2, div2, null);
    			append(div2, t5);
    			mount_component(programmesection3, div2, null);
    			current = true;
    		},
    		p(ctx, dirty) {
    			if (/*$isEnglish*/ ctx[1]) {
    				if (if_block0) {
    					if_block0.p(ctx, dirty);
    				} else {
    					if_block0 = create_if_block_1(ctx);
    					if_block0.c();
    					if_block0.m(div0, t1);
    				}
    			} else if (if_block0) {
    				if_block0.d(1);
    				if_block0 = null;
    			}

    			if (/*$isArabic*/ ctx[0]) {
    				if (if_block1) {
    					if_block1.p(ctx, dirty);
    				} else {
    					if_block1 = create_if_block(ctx);
    					if_block1.c();
    					if_block1.m(div0, null);
    				}
    			} else if (if_block1) {
    				if_block1.d(1);
    				if_block1 = null;
    			}

    			if (!current || dirty & /*$isArabic*/ 1) {
    				toggle_class(div0, "arabic", /*$isArabic*/ ctx[0]);
    			}

    			if (!current || dirty & /*$isArabic*/ 1) {
    				toggle_class(div1, "arabic", /*$isArabic*/ ctx[0]);
    			}

    			if (!current || dirty & /*$isArabic*/ 1) {
    				toggle_class(div2, "arabic", /*$isArabic*/ ctx[0]);
    			}
    		},
    		i(local) {
    			if (current) return;
    			transition_in(metadata.$$.fragment, local);

    			if (!div1_intro) {
    				add_render_callback(() => {
    					div1_intro = create_in_transition(div1, fade, {});
    					div1_intro.start();
    				});
    			}

    			transition_in(programmesection0.$$.fragment, local);
    			transition_in(programmesection1.$$.fragment, local);
    			transition_in(programmesection2.$$.fragment, local);
    			transition_in(programmesection3.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(metadata.$$.fragment, local);
    			transition_out(programmesection0.$$.fragment, local);
    			transition_out(programmesection1.$$.fragment, local);
    			transition_out(programmesection2.$$.fragment, local);
    			transition_out(programmesection3.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			destroy_component(metadata, detaching);
    			if (detaching) detach(t0);
    			if (detaching) detach(div3);
    			if (if_block0) if_block0.d();
    			if (if_block1) if_block1.d();
    			destroy_component(programmesection0);
    			destroy_component(programmesection1);
    			destroy_component(programmesection2);
    			destroy_component(programmesection3);
    		}
    	};
    }

    // (60:8) {#if $isEnglish}
    function create_if_block_1(ctx) {
    	let html_tag;
    	let raw_value = renderBlockText(/*programme*/ ctx[2].introduction.content.english) + "";
    	let html_anchor;

    	return {
    		c() {
    			html_tag = new HtmlTag(false);
    			html_anchor = empty();
    			html_tag.a = html_anchor;
    		},
    		m(target, anchor) {
    			html_tag.m(raw_value, target, anchor);
    			insert(target, html_anchor, anchor);
    		},
    		p: noop$1,
    		d(detaching) {
    			if (detaching) detach(html_anchor);
    			if (detaching) html_tag.d();
    		}
    	};
    }

    // (63:8) {#if $isArabic}
    function create_if_block(ctx) {
    	let html_tag;
    	let raw_value = renderBlockText(/*programme*/ ctx[2].introduction.content.arabic) + "";
    	let html_anchor;

    	return {
    		c() {
    			html_tag = new HtmlTag(false);
    			html_anchor = empty();
    			html_tag.a = html_anchor;
    		},
    		m(target, anchor) {
    			html_tag.m(raw_value, target, anchor);
    			insert(target, html_anchor, anchor);
    		},
    		p: noop$1,
    		d(detaching) {
    			if (detaching) detach(html_anchor);
    			if (detaching) html_tag.d();
    		}
    	};
    }

    // (53:18)     <div />  {:then programme}
    function create_pending_block(ctx) {
    	let div;

    	return {
    		c() {
    			div = element("div");
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);
    		},
    		p: noop$1,
    		i: noop$1,
    		o: noop$1,
    		d(detaching) {
    			if (detaching) detach(div);
    		}
    	};
    }

    function create_fragment$2(ctx) {
    	let await_block_anchor;
    	let current;

    	let info = {
    		ctx,
    		current: null,
    		token: null,
    		hasCatch: true,
    		pending: create_pending_block,
    		then: create_then_block,
    		catch: create_catch_block,
    		value: 2,
    		error: 6,
    		blocks: [,,,]
    	};

    	handle_promise(/*programme*/ ctx[2], info);

    	return {
    		c() {
    			await_block_anchor = empty();
    			info.block.c();
    		},
    		m(target, anchor) {
    			insert(target, await_block_anchor, anchor);
    			info.block.m(target, info.anchor = anchor);
    			info.mount = () => await_block_anchor.parentNode;
    			info.anchor = await_block_anchor;
    			current = true;
    		},
    		p(new_ctx, [dirty]) {
    			ctx = new_ctx;
    			update_await_block_branch(info, ctx, dirty);
    		},
    		i(local) {
    			if (current) return;
    			transition_in(info.block);
    			current = true;
    		},
    		o(local) {
    			for (let i = 0; i < 3; i += 1) {
    				const block = info.blocks[i];
    				transition_out(block);
    			}

    			current = false;
    		},
    		d(detaching) {
    			if (detaching) detach(await_block_anchor);
    			info.block.d(detaching);
    			info.token = null;
    			info = null;
    		}
    	};
    }

    const query$1 = '*[_type == "event" || (_type == "categoryIntroduction" && slug.current == "opening-programme")] | order(performanceDate asc) {simpleDate, startTime, performanceDate, eventType, _id, en_title, ar_title, en_content,  ar_content, mainImage, videoLink,  "category": _type, participants[]->{"en_title": en_name, en_title, ar_title, "slug": slug.current, "category": _type}, discussions[]->{en_title, ar_title, "slug": slug.current, "category": _type}}';

    function instance$1($$self, $$props, $$invalidate) {
    	let $isArabic;
    	let $isEnglish;
    	component_subscribe($$self, categoryList, $$value => $$invalidate(4, $$value));
    	component_subscribe($$self, isArabic, $$value => $$invalidate(0, $isArabic = $$value));
    	component_subscribe($$self, isEnglish, $$value => $$invalidate(1, $isEnglish = $$value));
    	let { language = "" } = $$props;
    	let programme = loadProgrammeData(query$1, {});

    	// Set globals
    	globalLanguage.set(language === "ar" ? "arabic" : "english");

    	isTileView.set(true);
    	activeNavigation.set("programme");

    	$$self.$$set = $$props => {
    		if ('language' in $$props) $$invalidate(3, language = $$props.language);
    	};

    	return [$isArabic, $isEnglish, programme, language];
    }

    class ProgrammeView extends SvelteComponent {
    	constructor(options) {
    		super();
    		init(this, options, instance$1, create_fragment$2, safe_not_equal, { language: 3 });
    	}
    }

    /* src\Views\Error404.svelte generated by Svelte v3.58.0 */

    function create_fragment$1(ctx) {
    	let metadata;
    	let t0;
    	let div1;
    	let current;
    	metadata = new MetaData({});

    	return {
    		c() {
    			create_component(metadata.$$.fragment);
    			t0 = space();
    			div1 = element("div");

    			div1.innerHTML = `<div>File Not Found (404)</div> 
  <a href="/">Go to landing page</a>`;

    			attr(div1, "class", "error-404 svelte-vwvbk3");
    		},
    		m(target, anchor) {
    			mount_component(metadata, target, anchor);
    			insert(target, t0, anchor);
    			insert(target, div1, anchor);
    			current = true;
    		},
    		p: noop$1,
    		i(local) {
    			if (current) return;
    			transition_in(metadata.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(metadata.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			destroy_component(metadata, detaching);
    			if (detaching) detach(t0);
    			if (detaching) detach(div1);
    		}
    	};
    }

    class Error404 extends SvelteComponent {
    	constructor(options) {
    		super();
    		init(this, options, null, create_fragment$1, safe_not_equal, {});
    	}
    }

    /* src\App.svelte generated by Svelte v3.58.0 */

    function create_default_slot(ctx) {
    	let route0;
    	let t0;
    	let route1;
    	let t1;
    	let route2;
    	let t2;
    	let route3;
    	let t3;
    	let route4;
    	let t4;
    	let route5;
    	let t5;
    	let route6;
    	let t6;
    	let route7;
    	let current;

    	route0 = new Route({
    			props: { path: "/", component: TileView }
    		});

    	route1 = new Route({
    			props: { path: "/:language", component: TileView }
    		});

    	route2 = new Route({
    			props: {
    				path: "/:language/programme",
    				component: ProgrammeView
    			}
    		});

    	route3 = new Route({
    			props: {
    				path: "/:language/:category",
    				component: TileView
    			}
    		});

    	route4 = new Route({
    			props: {
    				path: "/:language/:category/:slug",
    				component: PostView
    			}
    		});

    	route5 = new Route({
    			props: {
    				path: "/:language/introduction/:slug",
    				component: IntroductionView
    			}
    		});

    	route6 = new Route({
    			props: {
    				path: "/:language/page/:slug",
    				component: PageView
    			}
    		});

    	route7 = new Route({
    			props: { component: Error404, title: "404" }
    		});

    	return {
    		c() {
    			create_component(route0.$$.fragment);
    			t0 = space();
    			create_component(route1.$$.fragment);
    			t1 = space();
    			create_component(route2.$$.fragment);
    			t2 = space();
    			create_component(route3.$$.fragment);
    			t3 = space();
    			create_component(route4.$$.fragment);
    			t4 = space();
    			create_component(route5.$$.fragment);
    			t5 = space();
    			create_component(route6.$$.fragment);
    			t6 = space();
    			create_component(route7.$$.fragment);
    		},
    		m(target, anchor) {
    			mount_component(route0, target, anchor);
    			insert(target, t0, anchor);
    			mount_component(route1, target, anchor);
    			insert(target, t1, anchor);
    			mount_component(route2, target, anchor);
    			insert(target, t2, anchor);
    			mount_component(route3, target, anchor);
    			insert(target, t3, anchor);
    			mount_component(route4, target, anchor);
    			insert(target, t4, anchor);
    			mount_component(route5, target, anchor);
    			insert(target, t5, anchor);
    			mount_component(route6, target, anchor);
    			insert(target, t6, anchor);
    			mount_component(route7, target, anchor);
    			current = true;
    		},
    		p: noop$1,
    		i(local) {
    			if (current) return;
    			transition_in(route0.$$.fragment, local);
    			transition_in(route1.$$.fragment, local);
    			transition_in(route2.$$.fragment, local);
    			transition_in(route3.$$.fragment, local);
    			transition_in(route4.$$.fragment, local);
    			transition_in(route5.$$.fragment, local);
    			transition_in(route6.$$.fragment, local);
    			transition_in(route7.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(route0.$$.fragment, local);
    			transition_out(route1.$$.fragment, local);
    			transition_out(route2.$$.fragment, local);
    			transition_out(route3.$$.fragment, local);
    			transition_out(route4.$$.fragment, local);
    			transition_out(route5.$$.fragment, local);
    			transition_out(route6.$$.fragment, local);
    			transition_out(route7.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			destroy_component(route0, detaching);
    			if (detaching) detach(t0);
    			destroy_component(route1, detaching);
    			if (detaching) detach(t1);
    			destroy_component(route2, detaching);
    			if (detaching) detach(t2);
    			destroy_component(route3, detaching);
    			if (detaching) detach(t3);
    			destroy_component(route4, detaching);
    			if (detaching) detach(t4);
    			destroy_component(route5, detaching);
    			if (detaching) detach(t5);
    			destroy_component(route6, detaching);
    			if (detaching) detach(t6);
    			destroy_component(route7, detaching);
    		}
    	};
    }

    function create_fragment(ctx) {
    	let div;
    	let navigation;
    	let t0;
    	let router;
    	let t1;
    	let dustmachine;
    	let current;
    	navigation = new Navigation({});

    	router = new Router({
    			props: {
    				$$slots: { default: [create_default_slot] },
    				$$scope: { ctx }
    			}
    		});

    	dustmachine = new DustMachine({});

    	return {
    		c() {
    			div = element("div");
    			create_component(navigation.$$.fragment);
    			t0 = space();
    			create_component(router.$$.fragment);
    			t1 = space();
    			create_component(dustmachine.$$.fragment);
    			attr(div, "class", "app");
    			toggle_class(div, "arabic", /*$isArabic*/ ctx[0]);
    		},
    		m(target, anchor) {
    			insert(target, div, anchor);
    			mount_component(navigation, div, null);
    			append(div, t0);
    			mount_component(router, div, null);
    			append(div, t1);
    			mount_component(dustmachine, div, null);
    			current = true;
    		},
    		p(ctx, [dirty]) {
    			const router_changes = {};

    			if (dirty & /*$$scope*/ 16) {
    				router_changes.$$scope = { dirty, ctx };
    			}

    			router.$set(router_changes);

    			if (!current || dirty & /*$isArabic*/ 1) {
    				toggle_class(div, "arabic", /*$isArabic*/ ctx[0]);
    			}
    		},
    		i(local) {
    			if (current) return;
    			transition_in(navigation.$$.fragment, local);
    			transition_in(router.$$.fragment, local);
    			transition_in(dustmachine.$$.fragment, local);
    			current = true;
    		},
    		o(local) {
    			transition_out(navigation.$$.fragment, local);
    			transition_out(router.$$.fragment, local);
    			transition_out(dustmachine.$$.fragment, local);
    			current = false;
    		},
    		d(detaching) {
    			if (detaching) detach(div);
    			destroy_component(navigation);
    			destroy_component(router);
    			destroy_component(dustmachine);
    		}
    	};
    }

    const query = '*[_type == "satoshi"]{mainImage}';

    function instance($$self, $$props, $$invalidate) {
    	let $languagePrefix;
    	let $isArabic;
    	component_subscribe($$self, languagePrefix, $$value => $$invalidate(1, $languagePrefix = $$value));
    	component_subscribe($$self, isArabic, $$value => $$invalidate(0, $isArabic = $$value));
    	const satoshis = loadSatoshis(query);

    	satoshis.then(sats => {
    		satoshiList.set(shuffle_1(sats));
    	});

    	// Randomize category colors on each reload
    	const shuffledColors = shuffle_1(colorList);

    	categoryList.set(categoryListDefaults.map((c, i) => {
    		c.color = shuffledColors[i];
    		return c;
    	}));

    	$$self.$$.update = () => {
    		if ($$self.$$.dirty & /*$languagePrefix*/ 2) {
    			{
    				document.documentElement.lang = $languagePrefix;
    			}
    		}
    	};

    	return [$isArabic, $languagePrefix];
    }

    class App extends SvelteComponent {
    	constructor(options) {
    		super();
    		init(this, options, instance, create_fragment, safe_not_equal, {});
    	}
    }

    const app = new App({
      target: document.body
    });

    return app;

})();
//# sourceMappingURL=bundle.js.map
