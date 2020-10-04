<template>
    <div class="row justify-content-center">
        <div class="col-md-3  mb-1">
            <div class="card">
                <div class="card-header">
                    <h3 class="d-inline">Lists</h3>
                    <router-link tag="button"
                                 class="btn btn-success float-right"
                                 :to="{name: 'todo-create'}"> NEW
                    </router-link>
                </div>
                <div class="">
                    <ul class="list-group list-group-flush">
                        <router-link
                            tag="li"
                            :class="{'list-group-item-success': list.ready}"
                            v-for="list in todo_lists"
                            :key="list.id"
                            :to="{name:'todo-select', params:{todo_list_id: list.id}}"
                            class="list-group-item">
                                <div v-text="list.title" class="d-inline"></div>
                                <span class="badge badge-success float-right" v-if="list.ready">Ready</span>
                        </router-link>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {
    name: "task-todo-list-page",
    computed: {
        todo_lists() {
            return this.$store.state.todoLists.resources.all || []
        }
    }
}
</script>

<style scoped>
    .list-group{
        cursor: pointer;
    }
</style>
