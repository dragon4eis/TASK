<template>
    <tr class="task-row" :class="status">
        <td>{{ index + 1 }}</td>
        <td v-text="task.title"></td>
        <td v-text="task.deadline"></td>
        <td v-text="status"></td>
        <td>
            <div class="btn-group btn-group-sm" v-if="!expired">
                <button class="btn btn-secondary"  v-text="disableLabel" @click="$emit('disabled', !task.disabled)"></button>
                <template v-if="!task.disabled">
                    <button class="btn btn-success" v-if="!task.ready" @click="$emit('ready', true)">Ready</button>
                    <button class="btn btn-danger" v-else @click="$emit('ready', false)">Reopen</button>
                </template>
            </div>

        </td>
    </tr>
</template>

<script>
export default {
    name: "task-todo-task-row",
    props: {
        task: {
            type: Object,
            required: true
        },
        index: {
            type: Number,
            default: 0
        }
    },
    computed: {
        expired() {
            return moment().isAfter(moment(this.task.deadline))
        },
        status() {
            if (this.task.ready) {
                return 'ready'
            }else if (this.expired) {
                return 'expired'
            } else if (this.task.disabled) {
                return 'disabled'

            } else {
                return 'open'
            }
        },
        disableLabel(){
            return this.task.disabled ? 'Enable': 'Disable'
        }
    }
}
</script>

<style scoped>

</style>
