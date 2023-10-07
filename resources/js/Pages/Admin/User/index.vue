<template>
    <AdminAuthenticatedLayout>
        <!-- header -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users List
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">



<div class="relative overflow-x-auto shadow-md sm:rounded-lg">

    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Photo
                </th>
                <th scope="col" class="px-6 py-3">
                    Full Name/Email
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(user, index) in data.data" :key="index" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4">
                    <img class="w-10 h-10 rounded-full" :src="user.photo" :alt="user.fname+' '+ user.lname">
                </td>
                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                    
                    <div class="pl-3">
                        <div class="text-base font-semibold">{{user.fname}} {{user.lname}}</div>
                        <div class="font-normal text-gray-500">{{user.email}}</div>
                    </div>  
                </th>
                <td class="px-6 py-4">
                    <div class="flex items-center" v-if="user.status=='awaiting'">
                        <div class="h-2.5 w-2.5 rounded-full bg-yellow-500 mr-2"></div> Awaiting for approval
                    </div>
                    <div class="flex items-center" v-if="user.status=='approved'">
                        <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div> Approved
                    </div>
                    <div class="flex items-center" v-if="user.status=='rejected'">
                        <div class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2"></div> Rejected
                    </div>
                </td>
                <td class="px-6 py-4">
                    <a :href="'users/'+user.id+'/view'" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                </td>
            </tr>
            
        </tbody>
    </table>
    <pagination :links="data.links"></pagination>
</div>

                </div>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>

<script>
    import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
    import Pagination from '@/Components/Pagination.vue';

    export default{
        props: ['data'],
        components: {
            AdminAuthenticatedLayout,
            Pagination,
        },

    }

</script>
