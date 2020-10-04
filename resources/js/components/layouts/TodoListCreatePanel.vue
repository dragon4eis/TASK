<template>
    <div class="card">
        <div class="card-header"><h3>Create Todo List</h3></div>
        <div class="card-body">
            <todo-list-form v-model="form"></todo-list-form>
        </div>
        <div class="card-footer">
            <div class="btn-group float-right">
                <button class="btn btn-success" @click="submit">Save</button>
            </div>
        </div>
    </div>
</template>

<script>

import TodoListForm from "./forms/TodoListForm";
export default {
    name: "task-todo-task-create-panel",
    components: {TodoListForm},
    data() {
        return {
            form: {
                title: "",
                tasks: []
            }
        }
    },
    methods: {
        submit(){
            this.$store.dispatch('todoLists/submit', this.form)
                .then(response => {
                    this.$root.showSuccessMsg({message: response.data.message})
                    this.form = {title: "", tasks: []}
                })
                .catch(error => {
                    this.$root.showErrorMsg({message: error.response.data.message})
                })
        }
    }
}
</script>

<style scoped>

</style>
