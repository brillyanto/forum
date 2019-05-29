<template>
    <div>
        <div v-if="signedIn">
            <div class="input-group">
                    <textarea class="form-control" 
                    name="body" id="body" rows="3" 
                    v-model="body" placeholder="Have something to say.."></textarea>
            </div>
            <div class="input-group justify-content-end mt-4">
                    <input type="submit" class="btn btn-default" @click="addReply" value="Submit">
            </div>
        </div>
        <div v-else class="text-center">
            Please <a href="/login">SignIn</a> to participate
        </div>
    </div>
</template>

<script>

export default {
    data(){
        return {
            body: ''
        }
    },

    computed:{
        signedIn(){
            return window.App.signedIn;
        }
    },
    methods:{
        addReply(){
           axios.post(location.pathname + '/replies', { body: this.body})
           .then( ({data}) => {
               this.body = '';
               this.$emit('created', data);
           });
        }
    }
}
</script>