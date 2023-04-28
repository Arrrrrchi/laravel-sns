import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import ArticleLike from './components/ArticleLike.vue';
import ArticleTagsInput from './components/ArticleTagsInput.vue';

createApp({
    components: {
        ArticleLike,
        ArticleTagsInput,
    }
}).mount('#app');