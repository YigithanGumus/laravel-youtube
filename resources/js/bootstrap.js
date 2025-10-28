import axios from 'axios';
import { createApp, defineAsyncComponent } from 'vue'
import SayHello from './components/SayHello.vue';
import { ZiggyVue } from 'ziggy-js';
import { Ziggy } from './ziggy.js';
import { createPinia } from 'pinia'
import initStore from './mixin/init-store.js';
import { Confirm, Toast, Swal } from './lib/sweetalert/index.js';
import { LaravelValidationMessageSolver } from './lib/laravel-validation-solver.js'
import BlockUI from './lib/block-ui.js';

const Modal = window.Modal = defineAsyncComponent(() => import('./components/Modal.vue'))

window.SayHello = SayHello;

axios.interceptors.response.use(
    response => response,
    error => {
        // Laravel validation çözümü
        if (window.app?.config?.globalProperties?.$validationSolver) {
            error.solved = window.app.config.globalProperties.$validationSolver(error);
        }

        // Burada artık Swal çağrısı yok
        // Yani otomatik popup gösterilmeyecek
        // Konsola yazdırabiliriz debug için (opsiyonel)
        // console.warn('Axios Error:', error);

        return Promise.reject(error);
    }
);

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.app = createApp({
    mixins: [
        ...vueMixinFunctions?.map(mix => mix()) || [],
        typeof vueMixinFunction !== 'undefined' ? vueMixinFunction() : {},
    ],
    components: { Modal },
});

window.app.use(createPinia())
window.app.use(ZiggyVue, Ziggy);
window.app.mixin(initStore);

window.app.directive('inline', el => {
    if (!el) return;

    const content = el.tagName === 'TEMPLATE' ? el.content : el
    if (content.children.length === 1) {
        [...el.attributes].forEach(attr => content.firstChild.setAttribute(attr.name, attr.value))
    }

    if (el.tagName === 'TEMPLATE') {
        el.replaceWith(el.content)
    } else {
        el.replaceWith(...el.children)
    }
});

window.app.config.globalProperties.$block = new BlockUI();
window.app.config.globalProperties.$toast = Toast;
window.app.config.globalProperties.$swal = Swal;  // Artık otomatik kullanılmıyor
window.app.config.globalProperties.$confirm = Confirm;
window.app.config.globalProperties.$validationSolver = LaravelValidationMessageSolver;
