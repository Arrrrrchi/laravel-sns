import './bootstrap';
import { createApp } from 'vue';
import ArticleLike from './components/ArticleLike.vue';

const app = createApp(ArticleLike);
app.component('article-like', ArticleLike);
app.mount("#app");