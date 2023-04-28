<template>
    <input
        type="hidden"
        name="tags"
        :value="tagsJson"
    >
    <vue3-tags-input
        v-model="tag"
        :tags="tags"
        placeholder="タグを5個まで入力できます"
        :autocomplete-items="filteredItems"
        @on-tags-changed="newTags => tags = newTags"
        @keydown.backspace.prevent="handleBackspace"
    />
    <p class="tag_registor">タグ候補:</p>
    <ul class="tag_list">
        <li v-for="(tag, index) in filteredTags" :key="index" class="tag_item">{{ tag }}</li>
    </ul>
</template>

<script>
    import { defineComponent } from 'vue/dist/vue.esm-bundler.js';
    import Vue3TagsInput from 'vue3-tags-input';

    export default defineComponent({
        components: {
            Vue3TagsInput
        },
        props: {
            initialTags: {
                type: Array,
                default: [],
            },
            autocompleteItems: {
                type: Array,
                default: [],
            }
        },
        data() {
            return {
                tag: '',
                tags: this.initialTags,
                filteredTags: [],
            }
        },
        computed: {
            tagsJson() {
            return JSON.stringify(this.tags)
            },
            /* 入力値でタグを絞り込む */
            filteredItems() {
                this.filteredTags = this.autocompleteItems.filter(function (item) {
                    return item.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
                }, this);
            },
        },
        methods: {
            /* 入力中のバックスペースキーでタグを消さない */
            handleBackspace (event) {
                if (this.searchQuery === '') {
                    event.preventDefault();
                    const lastTag = this.tags.pop();
                    this.$emit('update:tags', this.tags);
                    this.$emit('tag-removed', lastTag);
                }
            }
        }
    })
</script>

<style lang="css" scoped>
    .vue3-tags-input {
        max-width: inherit;
    }
</style>
<style lang="css">
    .vue3-tags-input .ti-tag {
        background: transparent;
        border: 1px solid #747373;
        color: #747373;
        margin-right: 4px;
        border-radius: 0px;
        font-size: 13px;
    }
    .vue3-tags-input .ti-tag::before {
        content: "#";
    }
    .tag_registor {
        font-weight: bold;
    }
    .tag_list {
        display: flex;
        flex-wrap: wrap;
        padding-left: 0;
    }
    .tag_item {
        list-style: none;
        background-color: #317BAF;
        color: #ffffff;
        border-radius: 5px;
        font-size: 13px;
        height: 27px;
        padding: 3px;
        margin: 0px 2px 0px;
    }
</style>