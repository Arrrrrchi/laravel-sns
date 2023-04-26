// import './bootstrap';
// import Vue from 'vue';
// import { createApp } from 'vue';
// import ArticleLike from './components/ArticleLike.vue';

// Vue.createApp({
//     components: {
//         'article-like': ArticleLike
//     }
// }).mount('#app');

import './bootstrap';
import { createApp } from 'vue';
import ArticleLike from './components/ArticleLike.vue';

const app = createApp(ArticleLike);
app.component('article-like', ArticleLike);
app.mount("#app");