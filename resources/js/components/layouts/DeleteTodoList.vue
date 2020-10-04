<template>
    <div class="card">
        <div class="card-header"><h3>Delete todo list</h3></div>
        <div class="card-body" v-if="todo_list">
            <h6>Do you want to remove <strong>{{todo_list.title}}</strong> ?</h6>
        </div>
        <div class="card-footer">
            <div class="btn-group  float-right">
                <!--                                <button  class="btn btn-primary">View</button>-->
                <button class="btn btn-danger" @click="deleteList">Yes</button>
                <router-link tag="button"
                             class="btn btn-secondary"
                             :to="{name: 'todo-select', params: {todo_list_id}}">No</router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "task-todo-delete-todo-list",
    props:{
        todo_list_id:{
            required: true
        }
    },
    computed:{
        todo_list(){
            return this.$store.state.todoLists.resources.all.find(list => list.id === parseInt(this.todo_list_id)) || null
        }
    },
    methods:{
        deleteList(){
            this.$store.dispatch('todoLists/deleteElement', this.todo_list_id)
                .then((response) => {
                    this.$root.showSuccessMsg({message: response.data.message});
                    this.$router.push({name: 'todo-index', params:{todo_list_id: this.todo_list_id}})
                })
                .catch(error => {
                    console.error(error);
                    this.$root.showErrorMsg({message: error.response.data.message})
                })
        },
    }
}
</script>

<style scoped>

</style>
