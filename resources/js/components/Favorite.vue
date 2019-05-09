<template>
    <button type="submit" :class="classes" @click="toggle">
        <span>f <i class="fa fa-heart"></i></span>
        <span v-text="favoritesCount"></span>
    </button>
</template>

<script>
    export default{

        props:['reply'],

        data(){
            return{
                favoritesCount: this.reply.favoritesCount,
                isFavorited: this.reply.isFavorited
            }
        },

        computed:{
            classes(){
                return['btn btn-sm', this.isFavorited ? 'btn-primary' : 'btn-default'];
            }
        },

        methods: {
            toggle(){
               if(this.isFavorited) {
                    axios.delete('/replies/'+ this.reply.id + '/favorite');             
                    this.isFavorited = false;                                           
                    this.favoritesCount--;                                              
                } else {
                    axios.post('/replies/'+ this.reply.id +'/favorite');
                    this.isFavorited = true;        
                    this.favoritesCount++;          
               }
            }
        }

    }
</script>