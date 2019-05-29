<template>
   
    <ul class="pagination" v-if="shouldPaginate">
        <li v-if="prevUrl" @click.prevent="broadcast(page--)" class="page-item"><a class="page-link" href="#">Previous</a></li>
        <!-- <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li> -->
        <li v-if="nextUrl" @click.prevent="broadcast(page++)" class="page-item"><a class="page-link" href="#">Next</a></li>
    </ul>
   
</template>

<script>
export default{
    props: ['dataSet'],
    data(){
        return {
            prevUrl: false,
            nextUrl: false,
            page: 1,
        }
    },
    watch:{
        dataSet(){
            this.page = this.dataSet.current_page;
            this.prevUrl = this.dataSet.prev_page_url;
            this.nextUrl = this.dataSet.next_page_url;
        },
    },
    computed:{
        shouldPaginate(){
            return !! this.prevUrl || !! this.nextUrl;
        }
    },
    methods:{
        broadcast(page){
            this.$emit('fetchpage', this.page);
            history.pushState(null, null, '?page=' + this.page);
        }
    }
}
</script>