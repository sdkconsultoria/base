<template>
    <a @click="redirect">
        <slot></slot>
    </a>
</template>

<script>

export default {
    name: "CustomLink",
    props: {
        link: String,
    },
    data() {
        return {
           endpoint: '',
        };
    },
    methods: {
        redirect() {
        const urlParams = window.location.search.split('?');
        this.endpoint = this.link + '?' + urlParams[1];
        window.location.href = this.endpoint;
        // console.log(this.endpoint);;
    },
    }
};
</script>
