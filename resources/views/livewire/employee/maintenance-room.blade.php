<div>
    <h1 class="px-2 font-bold text-xl md:text-2xl pt-2">Location: {{$location->name}}</h1>
    <div class="flex flex-row flex-wrap-reverse justify-between mt-4 px-2 py-2">
        <div class="w-full md:w-1/2">
            <x-jet-input class="w-full" type="search" wire:model="search" placeholder="Search by Room"/>
        </div>
        <div class="w-full flex md:justify-end md:w-1/2 mb-3 md:mb-0">
            <x-jet-button class="w-full flex items-center justify-center md:w-auto" wire:click="add">Add Maintenance</x-jet-button>
        </div>
    </div>
    <br>
    @if (session()->has('success'))
    <div id="alert"  class="relative py-3 pl-4 pr-10 leading-normal text-green-700 bg-green-100 rounded-lg">
        <p>{{ session('success') }}</p>
    </div>
    <br>
    @endif

    <div class="overflow-x-auto mx-1">
        @if(count($maintenances) === 0 )
        <x-emptyTable>
            <x-slot name="header">
                Maintenance
            </x-slot>
            <x-slot name="content">
                @if(!empty($search))
                    There are no record of maintenance with the room name "{{$search}}"
                @else 
                    Looks like there are no maintenance at {{$location->name}}.
                @endif
            </x-slot>
        </x-emptyTable>
        @else
            <table class="min-w-full table-auto border-collapse border border-black">
                <thead>
                    <tr>
                        <th class="border border-gray-700 text-white bg-gray-700">Room</th>
                        <th class="border border-gray-700 text-white bg-gray-700">Description</th>
                        <th class="border border-gray-700 text-white bg-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($maintenances as $maintenance)
                        <tr class="text-center">
                            <td class="border border-gray-400 bg-gray-100">{{$maintenance ->room_name}}</td>
                            <td class="border border-gray-400 bg-gray-100">{{$maintenance ->description}}</td>
                            <td class="border border-gray-400  bg-gray-100 py-1.5">
                                <div class="border-none flex flex-row flex-nowrap justify-center">
                                    <x-jet-button class="mx-2" wire:click="edit({{$maintenance ->id}})">Edit</x-jet-button>
                                    <x-jet-button class="mx-2" wire:click="markAsComplete({{$maintenance->id}})">Completed</x-jet-button>
                                </div>
                            </td>
                        </tr>               
                    @endforeach
                </tbody>
            </table>
            <br>
            {{$maintenances->links()}}
        @endif

        {{-- add or edit --}}
        <x-jet-dialog-modal wire:model="maintenanceForm">
            <x-slot name="title">
                    @if($maintenance_id)
                        <h1>Edit Maintenance</h1>
                    @else
                        <h1>Add Maintenance</h1>
                    @endif
            </x-slot>
            <form>
                <x-slot name="content">
                    <x-jet-label for="room_id" value="Room Name"/>
                    @if($maintenance_id)
                        <select id="room_id" disabled wire:model.lazy="room_id" name="room_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="default">Select a Room</option>
                            @foreach($rooms as $room)
                                <option value="{{$room->id}}">{{$room->name}}</option>
                            @endforeach
                        </select>
                        @else
                        <select id="room_id"  wire:model.lazy="room_id" name="room_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="default">Select a Room</option>
                            @foreach($rooms as $room)
                                <option value="{{$room->id}}">{{$room->name}}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="room_id"/> 
                    @endif
                    
                    <x-jet-label for="employee_name" value="Employee Name"/>
                    <x-jet-input readonly id="employee_name" type="text" class="mt-1 block w-full" wire:model.lazy="employee_name"/>
                    <x-jet-input-error for="employee_id"/>

                    <x-jet-label for="description" value="Description" />
                    <x-jet-input id="description" type="text" class="mt-1 block w-full" wire:model.lazy="description"/>
                    <x-jet-input-error for="description"/>

                    <x-jet-input id="status" type="hidden" class="mt-1 block w-full" wire:model.lazy="status"/>
                </x-slot>
                <x-slot name="footer">
                    @if($maintenance_id)
                        <x-jet-button wire:click="store">Save</x-jet-button>
                    @else
                        <x-jet-button wire:click="store">Add</x-jet-button>
                    @endif
                    <x-jet-button wire:click="$toggle('maintenanceForm')">Cancel</x-jet-button>
                </x-slot>
            </form>
        </x-jet-dialog-modal>
        {{-- marked as complete --}}
        <x-jet-dialog-modal wire:model="completeConfirmationForm">
            <x-slot name="title">
                <h1>Complete Confirmation</h1>
            </x-slot>
            <form>
                <x-slot name="content">
                    <p>Are you sure you want to mark this maintenance at {{$room_name}} as completed.</p>
                    <x-jet-input id="room_name" type="hidden" class="mt-1 block w-full" wire:model.lazy="room_name"/>   
                    <x-jet-input id="description" type="hidden" class="mt-1 block w-full" wire:model.lazy="description"/>
                    <x-jet-input id="status" type="hidden" class="mt-1 block w-full" wire:model.lazy="status"/>
                </x-slot>
                <x-slot name="footer">
                    <x-jet-danger-button wire:click="store({{$maintenance_id}})">Completed</x-jet-button>
                    <x-jet-button wire:click="$toggle('completeConfirmationForm')">Cancel</x-jet-button>
                </x-slot>
            </form>
        </x-jet-dialog-modal>
    </div>
</div>
