import './bootstrap';
import { createApp } from 'vue';
import ArticleLike from './components/ArticleLike.vue';

const app = createApp(App);
app.component('article-like', ArticleLike);
app.mount("#app");