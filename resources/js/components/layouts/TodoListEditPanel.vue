<template>
    <div class="card">
        <div class="card-header"><h3>Create Todo List</h3></div>
        <div class="card-body">
            <todo-list-form v-if="form" v-model="form"></todo-list-form>
        </div>
        <div class="card-footer">
            <div class="btn-group float-right">
                <button class="btn btn-success" @click="submit">Save</button>
                <button class="btn btn-secondary" @click="close">Close</button>
            </div>
        </div>
    </div>
</template>

<script>
import TodoListForm from "./forms/TodoListForm";

export default {
    name: "task-toto-task-edit-panel",
    components: {TodoListForm},
    props: {
        todo_list_id: {
            required: true
        }
    },
    data() {
        return {
            form: {
                title:"",
                tasks: []
            }
        }
    },
    mounted() {
        this.load();
    },
    methods: {
        load() {
            axios.get(`todoList/${this.todo_list_id}`)
                .then(response => {
                    this.form = response.data
                })
                .catch(error => {
                    console.error(error);
                    this.$root.showErrorMsg(error)
                })
        },
        submit() {
            this.$store.dispatch('todoLists/submit', this.form)
                .then(response => {
                    this.$root.showSuccessMsg({message: response.data.message})
                    this.close()
                })
                .catch(error => {
                    this.$root.showErrorMsg({message: error.response.data.message})
                })
        },
        close() {
            this.$router.push({name: 'todo-select', params: {todo_list_id: this.todo_list_id}})
        }
    }
}
</script>

<style scoped>

</style>
