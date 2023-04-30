import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import ArticleLike from './components/ArticleLike.vue';
import ArticleTagsInput from './components/ArticleTagsInput.vue';
import FollowButton from './components/FollowButton.vue';

createApp({
    components: {
        ArticleLike,
        ArticleTagsInput,
        FollowButton,
    }
}).mount('#app');