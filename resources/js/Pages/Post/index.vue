<template>
    <Head title="Posts" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Posts</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <!--{{ $page.props?.posts }}-->
                    <button @click="deselectRows" class="px-4 py-2 bg-blue-500 text-gray-50 mb-2 rounded">Deselect rows</button>
                    <ag-grid-vue
                        style="width: 100%; height: 320px"
                        class="ag-theme-alpine w-full"
                        :columnDefs="columnDefs.value"
                        :rowData="rowData.value"
                        :defaultColDef="defaultColDef"
                        rowSelection="multiple"
                        animateRows="true"
                        @cell-clicked="cellWasClicked"
                        @grid-ready="onGridReady"
                    >
                    </ag-grid-vue>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import {Head} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {reactive, onMounted, ref} from "vue";
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-alpine.css";
import {AgGridVue} from "ag-grid-vue3";
import MedalCellRendererVue from "./medalCellRendererVue.js";
import TotalValueRendererVue from "./totalValueRendererVue.js";

export default {
    name: "App",
    components: {
        AgGridVue,
        AuthenticatedLayout,
        Head,
        medalCellRenderer: MedalCellRendererVue,
        totalValueRenderer: TotalValueRendererVue,
    },
    props: {
        posts: {
            required: true,
            type: Object
        }
    },
    setup() {
        const gridApi = ref(null); // Optional - for accessing Grid's API

        // Obtain API from grid's onGridReady event
        const onGridReady = (params) => {
            gridApi.value = params.api;
        };
        const rowData = reactive({}); // Set rowData to Array of Objects, one Object per Row
        // Each Column Definition results in one Column.
        const columnDefs = reactive({
            value: [
                { field: 'athlete' },
                { field: 'year' },
                {
                    field: 'gold',
                    cellRenderer: 'medalCellRenderer',
                },
                {
                    field: 'silver',
                    cellRenderer: 'medalCellRenderer',
                },
                {
                    field: 'bronze',
                    cellRenderer: 'medalCellRenderer',
                },
                {
                    field: 'total',
                    minWidth: 175,
                    cellRenderer: 'totalValueRenderer',
                },
            ],
        });
        // DefaultColDef sets props common to all Columns
        const defaultColDef = {
            editable: true,
            sortable: true,
            flex: 1,
            minWidth: 100,
            filter: true,
            resizable: true,
        };
        // Example load data from server
        onMounted(() => {
            fetch("https://www.ag-grid.com/example-assets/olympic-winners.json")
                .then((result) => result.json())
                .then((remoteRowData) => (rowData.value = remoteRowData));
        });

        return {
            onGridReady,
            columnDefs,
            rowData,
            defaultColDef,
            cellWasClicked: (event) => { // Example of consuming Grid Event
                console.log("cell was clicked", event);
            },
            deselectRows: () => {
                gridApi.value.deselectAll()
            },
            deleteLog: () => {
                console.log('deleteLog.')
            }
        };
    },
};
</script>

<style scoped>

</style>
