import TodoListPage from "../../components/pages/TodoListPage";
import ListPreview from "../../components/layouts/ListPreview";

const storeModule = 'todo';

export default {
    path: 'todo',
    name: `${storeModule}-index`,
    component: TodoListPage,
    children:[
        {
            path: ':todo_list_id(\\d+)',
            name: `${storeModule}-select`,
            props: {
                default: true
            },
            components:{
                default: ListPreview
            }
        }
    ]
}
