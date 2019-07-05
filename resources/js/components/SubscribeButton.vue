<template>
    <button class="btn btn-sm" :class="active ? 'btn-primary' : 'btn-default'" @click="subscribe">Subscribe</button>
</template>
<script>
    export default{
        props: ['active'],
        data(){
            return {
            }
        },
        methods:{
            subscribe(){
                let requestType = this.active ? 'delete' : 'post';
                axios[requestType](location.pathname + '/subscriptions');
                this.active = !this.active;
            }
        }
    }
</script>