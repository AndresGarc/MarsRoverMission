<script setup>
    import {ref} from 'vue';

    import SendSequenceForm from './SendSequenceForm.vue';
    import SelectRover from './SelectRover.vue';


    const rover_selected = ref(null);
    const get_rover_message = ref('');


</script>

<template>
    <header>
        <h1>Mars Rover Mission</h1>
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

</template>