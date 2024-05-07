<template>
    <div class="container mx-auto max-w-4xl pt-2">
        <section v-if="editor" class="border p-2 dark:bg-zinc-600 dark:border-gray-600 border-gray-400 focus:border-indigo-500 focus:ring-indigo-500 rounded-t-md">
            <button
                type="button"
                class="p-1 disabled:text-gray-400"
                @click="editor.chain().focus().undo().run()"
                :disabled="!editor.can().chain().focus().undo().run()"
            >
                <UndoIcon title="Undo" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().redo().run()"
                :disabled="!editor.can().chain().focus().redo().run()"
                class="p-1 disabled:text-gray-400"
            >
                <RedoIcon title="Redo" />
            </button>
            
            <button
                type="button"
                @click="editor.chain().focus().toggleBold().run()"
                :class="{ 'bg-gray-200 rounded': editor.isActive('bold') }"
                class="p-1"
            >
                <BoldIcon title="Bold" />
            </button>
            <button @click.prevent="addImage" class="p-1">
                <ImageIcon title="Image"/>
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleItalic().run()"
                :class="{ 'bg-gray-200 rounded': editor.isActive('italic') }"
                class="p-1"
            >
                <ItalicIcon title="Italic" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleUnderline().run()"
                :class="{ 'bg-gray-200 rounded': editor.isActive('underline') }"
                class="p-1"
            >
                <UnderlineIcon title="Underline" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
                :class="{
                'bg-gray-200 rounded': editor.isActive('heading', { level: 1 }),
                }"
                class="p-1"
            >
                <H1Icon title="H1" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
                :class="{
                'bg-gray-200 rounded': editor.isActive('heading', { level: 2 }),
                }"
                class="p-1"
            >
                <H2Icon title="H2" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleBulletList().run()"
                :class="{ 'bg-gray-200 rounded': editor.isActive('bulletList') }"
                class="p-1"
            >
                <ListIcon title="Bullet List" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleOrderedList().run()"
                :class="{ 'bg-gray-200 rounded': editor.isActive('orderedList') }"
                class="p-1"
            >
                <OrderedListIcon title="Ordered List" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleBlockquote().run()"
                :class="{ 'bg-gray-200 rounded': editor.isActive('blockquote') }"
                class="p-1"
            >
                <BlockquoteIcon title="Blockquote" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleCode().run()"
                :class="{ 'bg-gray-200 rounded': editor.isActive('code') }"
                class="p-1"
            >
                <CodeIcon title="Code" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().setHorizontalRule().run()"
                class="p-1"
            >
                <HorizontalRuleIcon title="Horizontal Rule" />
            </button>
            <input class="h-[32px] w-[32px] ml-1"
                type="color"
                @input="editor.chain().focus().setColor($event.target.value).run()"
                :value="editor.getAttributes('textStyle').color"
            >
            <button class="p-1 ml-2" type="button" @click.prevent="editor.chain().focus().unsetColor().run()">
                <FormatColor title="Remove Color" />
            </button>
        </section>
        <editor-content :editor="editor"/>
        <div class="character-count text-gray-400 text-sm m-2" v-if="editor">
        {{ editor.storage.characterCount.characters() }}/{{ limit }} characters
        </div>
    </div>
    



    <Modal :show="showModalImg" @close="showModalImg = false" maxWidth="sm">
            <a @click.prevent="showModalImg=false" class="hover:text-red-500 dark:text-white dark:hover:text-red-500 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </a>
            <p v-if="message" class="text-red-500 p-2 text-center">
                {{ message }}
            </p>
            <input type="file" id="img" @change="handleImageUpload" class="border-gray-300 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full p-5 px-10"></input>
            
    </Modal>
</template>

<script setup>
    import { useEditor, EditorContent } from '@tiptap/vue-3'
    import StarterKit from '@tiptap/starter-kit'
    import CharacterCount from '@tiptap/extension-character-count'
    import Image from '@tiptap/extension-image'
    import Paragraph from '@tiptap/extension-paragraph'
    import Text from '@tiptap/extension-text'
    import Modal from './Modal.vue';
    import { ref } from 'vue';
    import { uploadImages } from './AdminPanel/services/uploadImages';
    import { Color } from '@tiptap/extension-color'
    import Underline from '@tiptap/extension-underline'
    import TextStyle from '@tiptap/extension-text-style'
    import BoldIcon from 'vue-material-design-icons/FormatBold.vue'
    import ItalicIcon from 'vue-material-design-icons/FormatItalic.vue'
    import UnderlineIcon from 'vue-material-design-icons/FormatUnderline.vue'
    import H1Icon from 'vue-material-design-icons/FormatHeader1.vue'
    import H2Icon from 'vue-material-design-icons/FormatHeader2.vue'
    import ListIcon from 'vue-material-design-icons/FormatListBulleted.vue'
    import OrderedListIcon from 'vue-material-design-icons/FormatListNumbered.vue'
    import BlockquoteIcon from 'vue-material-design-icons/FormatQuoteClose.vue'
    import CodeIcon from 'vue-material-design-icons/CodeTags.vue'
    import HorizontalRuleIcon from 'vue-material-design-icons/Minus.vue'
    import UndoIcon from 'vue-material-design-icons/Undo.vue'
    import RedoIcon from 'vue-material-design-icons/Redo.vue'
    import ImageIcon from 'vue-material-design-icons/Image.vue';
    import FormatColor from 'vue-material-design-icons/WaterOff.vue';



    const props = defineProps({
        modelValue: String,
    })

    const limit = 500;
    const showModalImg = ref(false);
    const message = ref('');

    const emit = defineEmits(['update:modelValue'])

    const editor = ref(useEditor({
    content: props.modelValue,
    onUpdate: ({editor}) => {
        emit('update:modelValue', editor.getHTML())
    },
    extensions: [
        StarterKit,
        CharacterCount.configure({
          limit: limit,
        }),
        Image.configure({
            allowBase64: true,
            HTMLAttributes: {
                class: 'p-1',
                tabindex: 0 
            }
        }),
        Paragraph,
        Text,
        Underline,
        TextStyle,
        Color
    ],
    editorProps: {
        attributes: {
            class: 'border dark:text-white dark:border-gray-600 p-4 rounded-b-md shadow-sm overflow-y-auto max-h-[28rem] min-h-[14rem] prose max-w-none'
        }
    }
    }))

    console.log('fuera funcion: ');
    console.log(editor)
    
    const handleImageUpload = async (event) => {
        const file = event.target.files[0]; // Accede al archivo seleccionado
        const allowedExtensions = ["png", "jpg", "jpeg"]; // Extensiones permitidas

        // Verifica si se seleccionó un archivo
        if (file) {
            console.log(file)
            const extension = file.name.split('.').pop().toLowerCase(); // Obtiene la extensión del archivo
            // Verifica si la extensión es PNG o JPG
            if (!allowedExtensions.includes(extension)) {
                // Abre el modal si la extensión no está permitida
                message.value = 'This extension doesnt support images'
                event.target.value = ''; // Limpia el valor del campo de carga de archivos
            } else {
                let formData = new FormData()
                // Agrega los datos del archivo a las peticiones POST
                formData.append("image", file);
                
                const url = await uploadImages(formData);

                editor.value.chain().focus().setImage({src: url}).run();

                //Inserto al editor
                showModalImg.value = false;
                
            }
        }
    }

    const addImage = () =>{
        showModalImg.value = true;
    }
    
</script>

<style>
    .ProseMirror-focused {
        border-color: indigo !important;
    }
</style>