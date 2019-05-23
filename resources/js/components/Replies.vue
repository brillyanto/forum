<template>
    <div>
        <div v-for="(reply, index) in items" :key="index">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>

        <new-reply @created="add" :endpoint="endpoint"></new-reply>

    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from './NewReply.vue';

    export default{
        props:['data'],
        components: { Reply, NewReply },
        data(){
            return {
                items: this.data,
            }
        },
        computed:{
            endpoint(){
                return location.pathname + '/replies';
            }
        },
        methods:{
            add(dd){
                this.items.push(dd);
                this.$emit('added');
                flash('reply was added');
            },
            remove(index){
                this.items.splice(index, 1);
                this.$emit('removed');
                flash('reply was deleted');
            }
        }
    }
</script>


