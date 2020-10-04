<template>
    <div class="card">
        <div class="card-header"><h3>Preview</h3></div>
        <div class="card-body" v-if="todo_list">
            <h4 v-text="todo_list.title" :class="{'text-success': todo_list.ready}"></h4>
            <task-todo-task-table :tasks="todo_list.tasks"
                                  :todo_list_id="todo_list_id"></task-todo-task-table>
        </div>
        <div class="card-footer">
            <div class="btn-group  float-right">
                <!--                                <button  class="btn btn-primary">View</button>-->
                <router-link tag="button"
                             class="btn btn-secondary"
                             :to="{name: 'todo-edit', params: {todo_list_id}}">Edit </router-link>
                <router-link tag="button"
                             class="btn btn-danger"
                    :to="{name: 'todo-delete', params: {todo_list_id}}">Delete</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import TaskTodoTaskTable from "./tables/TaskTable";
export default {
    name: "task-todo-list-preview",
    components: {TaskTodoTaskTable},
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
}
</script>

<style scoped>

</style>
