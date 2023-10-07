
<template>
    <Head title="User Details" />

    <AdminAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">User Details</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md my-3" role="alert" v-if="$page.props.flash.success">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ $page.props.flash.success }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md my-3" role="alert" v-if="$page.props.flash.error">
                        <div class="flex">
                            <div>
                                <p v-if="$page.props.flash.error" class="text-sm">{{ $page.props.flash.error }}</p>
                            </div>
                        </div>
                    </div>               

                    <div class="p-6 text-right">
                        <a href="/admin/users" class="text-black font-bold py-2 px-4 rounded">Back</a>
                    </div>
                </div>

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
      <div class="mx-auto my-5 bg-white rounded-lg shadow-md p-5">
        <!-- 
        <img class="w-32 h-32 rounded-full mx-auto" src="https://picsum.photos/200" alt="Profile picture">
        -->
        <p class="text-center">
            <img class="w-32 h-32 rounded-full mx-auto" :src="'../storage'+user.photo" :alt="user.fname+' '+user.lname">
        </p>


        <h2 class="text-center text-2xl font-semibold mt-3">{{user.fname}} {{user.lname}}</h2>

        <p class="text-center mt-1">
        <a :href="'mailto:'+user.email" class="text-center text-2xl text-blue-600 mt-3">{{user.email}}</a>
        </p>

        <p class="text-center text-gray-600 mt-1">Status: {{user.status}}</p>
        <div class="text-center justify-center mt-5">
          <div class="text-gray-600 mx-3">Registeration: {{user.created_at}}</div>

          <div class="text-gray-600 mx-3">Last Updated: {{user.updated_at}}</div>
        </div>

        <div class="m-5">
            <h3 class="text-xl font-semibold">Documents</h3>
            <div class="text-gray-600 mt-2 mb-2">

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    File Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Uploaded Time
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(document, index) in documents" :key="index" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <a :href="document.path" target="_blank" :alt="document.name">{{document.name}}</a>
                                </th>
                                <td class="px-6 py-4">
                                    {{document.created_at}}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a :href="document.path" download="" target="_self" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Download</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="m-5 p-6 text-center">

            <PrimaryButton v-if="user.status=='awaiting' || user.status=='rejected'" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" @click="changeStatus(user.id, 'approved')">Approve</PrimaryButton>
            <PrimaryButton v-if="user.status=='awaiting'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" @click="changeStatus(user.id, 'rejected')">Reject</PrimaryButton>

        </div>

      </div>
    </div>
</div>
<!--  -->

            </div>
        </div>

    </AdminAuthenticatedLayout>
</template>


<script>
    import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';

    export default{
        props: [
            'user',
            'documents',
        ],
        components: {
            AdminAuthenticatedLayout,
        },
        data()
        {
            return {
                
            }
        },
        methods: {
            changeStatus(id, status)
            {
                this.$inertia.post(route('admin.user.changestatus', {user:id}), {status:status}, {
                    onError: () => {

                    },
                    onSuccess: () => {

                    }
                });
            },

        }
    }
</script>
