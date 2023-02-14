import './bootstrap';
import { createApp } from 'vue';
import Toaster from '@meforma/vue-toaster';
import mitt from 'mitt';
import axios from 'axios';
import * as bootstrap from 'bootstrap';

const app = createApp({});

class VueEventWrapper {
    constructor() {
        this.emitter = mitt();
    }

    fire(event, data) {
        this.emitter.emit(event, data);
    }

    listen(event, callBack) {
        this.emitter.on(event, callBack);
    }
}

window.CustomEvent = new VueEventWrapper();
window.bootstrap = bootstrap;
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Vue components
import TableList from './components/TableList.vue';
import BooksTableList from './components/BooksTableList.vue';
import BookForm from './components/BookForm.vue';
import SearchComponent from './components/SearchComponent/SearchComponent.vue';

app.use(Toaster);
app.component('table-list', TableList);
app.component('books-table-list', BooksTableList);
app.component('book-form', BookForm);
app.component('search', SearchComponent);

app.mount('#app');
