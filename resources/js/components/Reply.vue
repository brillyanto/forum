<template>
    <div :id="'reply-'+id" class="card mt-2">
        <div class="card-header">
            <div class="level">
                <div class="flex">
                <a :href="'/profiles/'+data.owner.name" v-text="data.owner.name"></a>
                    created at  <span v-text="ago"></span>
                </div>
               
                <div v-if="signedIn">
                    <favorite :reply="data"></favorite>
                </div>
                  
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" name="editreply" id="editreply" v-model="body"></textarea>
                </div>
                <button class="btn btn-sm btn-primary" @click="update">Update</button>
                <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
            </div>
            <article v-else v-text="body"></article>
        </div>

        <!-- @can('update', $reply) -->
        <div class="card-footer level" v-if="canUpdate">
            <button class="btn btn-sm btn-link mr-1" @click="editing = true">Edit</button>
            <button class="btn btn-sm btn-danger" @click="destroy">Delete</button>
        </div>
        <!-- @endcan -->
    </div>
</template>

<script>
import Favorite from './Favorite.vue';
import moment from 'moment';


export default{
    props:['data'],
    data(){
        return{
            editing: false,
            id: this.data.id,
            body: this.data.body,
        };
    },
    components: { Favorite },
    computed:{
        ago(){
            return moment(this.data.created_at).fromNow();
        },
        signedIn(){
            return window.App.signedIn;
        },
        canUpdate(){
           return this.authorize(user => this.data.user_id == user.id);
            //return this.data.user_id == window.App.user.id;
        }
    },
    methods:{
        update(){
            axios.patch('/replies/'+ this.data.id, {
                body: this.body
            });
            this.editing = false;
            flash('updated!');
        },
        destroy(){
            axios.delete('/replies/'+ this.data.id);
            this.$emit('deleted', this.data.id);
        }
    }
}
</script>