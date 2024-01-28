<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('List Information') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Update your coordinate information.") }}
                            </p>
                        </header>
                        <form action="{{ route('listings.update') }}" method="post">
                            @csrf
                            @method('post')
                            <input type="hidden" name="list_id" value="{{ $listing->id }}">
                            <div class="grid gap-6 mb-6 md:grid-cols-2 mt-4">
                                <div>
                                    <label for="list_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">List name</label>
                                    <input name="list_name" type="text" id="list_name" value="{{ $listing->name ?? '' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                </div>
                                <div>
                                    <label for="latitude" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Latitude</label>
                                    <input name="latitude" type="text" id="latitude" value="{{ $listing->latitude ?? 0 }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                </div> 
                                <div>
                                    <label for="longitude" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Longitude</label>
                                    <input name="longitude" type="text" id="longitude" value="{{ $listing->longitude ?? 0 }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Flowbite" required>
                                </div>  
                            </div>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#update-form').submit(function(event) {
            event.preventDefault(); 

          
            var csrfToken = "{{ csrf_token() }}";      
            var formData = $(this).serialize();
       
        
            $.ajax({
                type: 'POST',
                url: '/listings/update',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                dataType: 'json',
                success: function(response) {
                    // Handle success response
                    // Close the modal
                    // $('[data-modal-toggle="edit-modal"]').click();
                    // $('[data-modal-target="edit-modal"]').click();
                    closeEdit.click();
                },
                error: function(error) {
                    // Handle error
                    console.error('Error:', error);
                    $('#create_new').html('Add list'); // Reset button text
                },
            });
        });
    });
</script>


