<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>
        <paginator @fetchpage="fetch" :dataSet="dataSet"></paginator>
        <new-reply @created="add"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from './NewReply.vue';
    import Collections from '../mixins/Collections';

    export default{

        components: { Reply, NewReply },
        mixins: [Collections],

        data(){
            return {
                dataSet: false,
            }
        },

        computed:{
            endpoint(){
                return location.pathname + '/replies';
            }
        },

        created(){
           this.fetch();
        },

        methods:{

            fetch(page){
                axios.get(this.url(page))
                .then(this.refresh);
            },

            url(page){

                if(!page){
                    let query = location.search.match(/page=(\d+)/);
                    page = query ? query[1] : 1;
                }

                return `${location.pathname}/replies?page=${page}`;
            },

            refresh({data}){
                // console.log(data);
                this.dataSet = data;
                this.items = data.data;
            },

        }
    }
</script>


