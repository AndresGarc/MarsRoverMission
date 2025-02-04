<script setup>
    import {ref} from 'vue';

    import SendSequenceForm from './SendSequenceForm.vue';
    import SelectRover from './SelectRover.vue';


    const rover_selected = ref(null);
    const get_rover_message = ref('');


</script>

<template>
    <div class="max-w-lg mx-6 p-8 bg-gray-100 rounded-lg border-4 border-white shadow-black/20 shadow-lg">
        <header>
            <h1 class="mb-4 text-2xl font-semibold text-center">
                Mars Rover Mission
            </h1>
        </header>

        <SelectRover 
            :rover_selected="rover_selected" 
            :get_rover_message="get_rover_message"
            @update:rover_selected="rover_selected = $event" 
            @update:rover_message="get_rover_message = $event" 
            />

        <SendSequenceForm 
            :rover_selected="rover_selected"
            @update:rover_message="get_rover_message = $event" 
        />
    </div>

</template>