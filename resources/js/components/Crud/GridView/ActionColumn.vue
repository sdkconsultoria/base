<template>
    <div class="flex">
        <DeleteModel v-if="template_actions.delete" :translations="$parent.translations" :routes="$parent.routes" :model_id="model_id">
            <button class="h-5 w-5 mr-1 text-gray-400" type="submit">
                <TrashIcon />
            </button>
        </DeleteModel>
        <a v-if="template_actions.update" :href="`${$parent.routes.resource}/update/${model_id}`">
            <PencilIcon class="h-5 w-5 mr-1 text-gray-400" />
        </a>
        <a v-if="template_actions.show"  :href="`${$parent.routes.resource}/${model_id}`">
            <EyeIcon class="h-5 w-5 mr-1 text-gray-400" />
        </a>
    </div>
</template>

<script>
import { TrashIcon, PencilIcon, EyeIcon } from "@heroicons/vue/24/outline";
import DeleteModel from "./../Form/DeleteModelComponent.vue";

export default {
    name: "ActionColumn",
    props: {
        model_id: Number,
        template_actions: {
            default: {
                'update': true,
                'delete': true,
                'show': true,
            }
        },
    },
    components: {
        TrashIcon,
        PencilIcon,
        EyeIcon,
        DeleteModel,
    },
};
</script>
