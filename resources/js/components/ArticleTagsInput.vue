<template>
    <input
        type="hidden"
        name="tags"
        :value="tagsJson"
    >
    <vue3-tags-input 
        :tags="tags"
        placeholder="タグを5個まで入力できます"
        @on-tags-changed="newTags => tags = newTags"
    />
</template>

<script>
    import { defineComponent } from 'vue/dist/vue.esm-bundler.js';
    import Vue3TagsInput from 'vue3-tags-input';

    export default defineComponent({
        components: {
            Vue3TagsInput
        },

        data() {
            return {
                tags: []
            }
        },
        computed: {
            tagsJson() {
            return JSON.stringify(this.tags)
            },
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
</style>