@extends('layouts.app')
@section('bodycontent')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <a href="{{ route('students.index') }}" title="back" class="inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150" ><img src="{{ asset('assets/back.svg') }}" alt="Back Icon" class="w-3 h-3"></a><br><br>
                <h5 class="font-bold text-center text-black">Add Student Details</h5><br>                
                <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @php 
                        $users = App\Models\User::all();
                    @endphp
                    <div>
                        <label for="saff_id">Assign to Staff</label><br>
                        <select name="saff_id" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" required>
                            <option value="" disabled selected>Select staff member from here</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->fname }} {{ $user->lname }}</option>
                            @endforeach
                        </select> 
                    </div>
                    @error('saff_id') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
                    <br>
                    <div>
                        <label for="name">Enter Child's Name</label><br>
                        <input type="text" name="name" id="name" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" placeholder="child's name" required>
                    </div>
                    @error('name') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
                    <br>
                    <div>
                        <label for="gender">Select Child's Gender</label><br>
                        <select name="gender" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" required>
                            <option value="" disabled selected>Select from here</option>
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                            <option value="3">Other</option>
                        </select> 
                    </div>
                    @error('gender') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
                    <br>
                    <div id="records-container" class="overflow-x-auto">
                        <div class="record"> 
                            <div>
                                <label for="parents">Select to Parent/Guardian</label><br>
                                <select name="parents[]" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" required>
                                    <option value="" disabled selected>Select parent/guardian from here</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->fname }} {{ $user->lname }}</option>
                                    @endforeach
                                </select> 
                            </div>
                            @error('parents') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
                            <br>
                        </div>
                    </div>
                    <div>
                        <button type="button" onclick="addRecord()" class="inline-flex items-center px-4 py-2 mt-2 mb-4 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-25">
                            Add Another Parent
                        </button>
                    </div>
                    <div>
                        <label for="membership">Select Membership Type</label><br>
                        <select name="membership" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" required>
                            <option value="" disabled selected>Select type from here</option>
                            <option value="1">Daily</option>
                            <option value="2">Monthly</option>
                            <option value="3">Yearly</option>
                        </select> 
                    </div>
                    @error('membership') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
                    <br>                                       
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-25">Save</button>                        
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function addRecord() {
        // Clone the first record and append it to the container
        var firstRecord = document.querySelector('.record');
        var newRecord = firstRecord.cloneNode(true);
        
        // Reset the values of the cloned inputs
        var inputs = newRecord.querySelectorAll('input');
        inputs.forEach(input => input.value = '');

        // Add delete button to the cloned record only
        var deleteButton = document.createElement('button');
        deleteButton.setAttribute('type', 'button');
        deleteButton.className = 'mt-2 mb-4 inline-flex px-2 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 delete-button';
        deleteButton.innerHTML = '<img src="{{ asset('assets/xmark.svg') }}" alt="X Icon" class="w-3 h-3">';
        deleteButton.onclick = function() { removeRecord(deleteButton) };
        newRecord.insertBefore(deleteButton, newRecord.firstChild);

        document.getElementById('records-container').appendChild(newRecord);
    }

    function removeRecord(button) {
        var record = button.parentNode;
        document.getElementById('records-container').removeChild(record);
    }
</script>