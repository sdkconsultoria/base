<template>
    <div v-if="editor">
        <div class="textarea">
            <editor-content :editor="editor" />
        </div>
        <div id="toolbar" class="flex items-center justify-end p-3 border-t space-x-4 dark:border-gray-700" v-if="editor">
            <button id="bold-button" class="btn btn-xs" :class="boldIsActive"
                @click="editor.chain().focus().toggleBold().run()">
                <strong>B</strong>
            </button>
            <button id="italic-button" class="btn btn-xs" :class="italicIsActive"
                @click="editor.chain().focus().toggleItalic().run()">
                <i>I</i>
            </button>
            <button id="strike-button" class="btn btn-xs" :class="strikeIsActive"
                @click="editor.chain().focus().toggleStrike().run()">
                <s>S</s>
            </button>
            <button id="underline-button" class="btn btn-xs" :class="underlineIsActive"
                @click="editor.chain().focus().toggleUnderline().run()">
                <u>U</u>
            </button>

            <button @click="editor.chain().focus().setTextAlign('left').run()" class="btn btn-xs"
                :class="{ 'is-active': editor.isActive({ textAlign: 'left' }) }">
                <Bars3BottomLeftIcon style="height: 15px;" />
            </button>
            <button @click="editor.chain().focus().setTextAlign('center').run()" class="btn btn-xs"
                :class="{ 'is-active': editor.isActive({ textAlign: 'center' }) }">
                <Bars2Icon style="height: 15px;" />

            </button>
            <button @click="editor.chain().focus().setTextAlign('right').run()" class="btn btn-xs"
                :class="{ 'is-active': editor.isActive({ textAlign: 'right' }) }">
                <Bars3BottomRightIcon style="height: 15px;" />
            </button>
        </div>
    </div>
</template>

<script>
import StarterKit from '@tiptap/starter-kit'
import { Editor, EditorContent } from '@tiptap/vue-3'
import Bold from '@tiptap/extension-bold'
import Document from '@tiptap/extension-document'
import Paragraph from '@tiptap/extension-paragraph'
import Text from '@tiptap/extension-text'
import Italic from '@tiptap/extension-italic'
import Underline from '@tiptap/extension-underline'
import Strike from '@tiptap/extension-strike'
import TextAlign from '@tiptap/extension-text-align'
import { Bars2Icon, Bars3BottomLeftIcon, Bars3CenterLeftIcon, Bars3BottomRightIcon } from '@heroicons/vue/24/solid'


export default {
    components: {
        EditorContent, Bars2Icon, Bars3BottomLeftIcon, Bars3BottomRightIcon

        ,
    },

    props: {
        modelValue: {
            type: String,
            default: '',
        },
    },

    emits: ['update:modelValue'],

    data() {
        return {
            editor: null,
        }
    },

    methods: {
        isActive(is_active) {
            return {
                'bg-gray-400': is_active
            };
        },
    },
    computed: {
        boldIsActive() {
            return this.isActive(this.editor.isActive('bold'));
        },
        italicIsActive() {
            return this.isActive(this.editor.isActive('italic'));
        },
        strikeIsActive() {
            return this.isActive(this.editor.isActive('strike'));
        },
        underlineIsActive() {
            return this.isActive(this.editor.isActive('underline'));
        },
    },

    watch: {
        modelValue(value) {
            // HTML
            const isSame = this.editor.getHTML() === value

            // JSON
            // const isSame = JSON.stringify(this.editor.getJSON()) === JSON.stringify(value)

            if (isSame) {
                return
            }

            this.editor.commands.setContent(value, false)
        },
    },

    mounted() {
        this.editor = new Editor({
            extensions: [
                StarterKit,
                Document,
                Paragraph,
                Text,
                Bold,
                Italic,
                Underline,
                Strike,
                TextAlign.configure({
                    types: ['paragraph'],
                }),
            ],
            content: this.modelValue,
            onUpdate: () => {
                // HTML
                this.$emit('update:modelValue', this.editor.getHTML())

                // JSON
                // this.$emit('update:modelValue', this.editor.getJSON())
            },
        })
    },

    beforeUnmount() {
        this.editor.destroy()
    },
}
</script>
<style>
.ProseMirror-focused {
    outline: none;
}

.ProseMirror {
    min-height: 80px;
    overflow-y: auto;
    font-size: 20px;
}
</style>
