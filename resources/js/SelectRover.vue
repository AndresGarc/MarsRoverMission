<script setup>

    import {ref, onMounted} from 'vue';
    import axios from 'axios';

    const props = defineProps(['rover_selected', 'get_rover_message']);

    const emit = defineEmits([
        'update:rover_selected',
        'update:rover_message'
    ])
    
    const rover_list = ref([]);
    const local_rover_selected = ref(props.rover_selected);


    const fetchRovers = async() => {
        await axios.get('/rovers')
            .then(function (response) {
                rover_list.value = response.data;
            })
            .catch(function (error) {
                emit('update:rover_message', error.data.message);
            });
    }

    const roverSelected = async() => {

        emit('update:rover_selected', local_rover_selected.value);
        await axios.get('rover/' + local_rover_selected.value + '/position')
            .then(function (response) {
                emit('update:rover_message', 'Rover ' + local_rover_selected.value + ': (' + response.data.row + ',' + response.data.column + '), ' + response.data.direction); 
            })
            .catch(function(error) {
                switch (error.status) {
                    case 422:
                        emit('update:rover_message', error.response.data.message);
                        break;
                
                    default:
                        emit('update:rover_message', error.response.data.error);
                        break;
                }
            });
    }



    onMounted(() => {
        fetchRovers();
    });

</script>

<template>

    <div class="mb-8">
        <label for="rover" class="block mb-2 font-semibold">Select Rover</label>
        <select 
            name="rover" id="rover" @change="roverSelected" v-model="local_rover_selected"
            class="rounded border-neutral-400 focus:border-red-900 focus:focus:ring-red-900">
            <option disabled selected>Select rover</option>
            <option v-for="rover in rover_list" :value="rover.id">
                {{ rover.name }}
            </option>
        </select>
        <p class="mt-2">{{ props.get_rover_message }}</p>
    </div>

</template>