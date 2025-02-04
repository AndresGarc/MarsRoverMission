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
        try {
            const response = await axios.get('/rovers');
            rover_list.value = response.data;
            
        } catch (error) {
            // lanzar mensajito de error para avisar al usuario
        }
    }

    const roverSelected = async() => {
        try {

            emit('update:rover_selected', local_rover_selected.value);
            const response = await axios.get('rover/' + local_rover_selected.value + '/position');
            emit('update:rover_message', 'Rover ' + local_rover_selected.value + ': (' + response.data.row + ',' + response.data.column + '), ' + response.data.direction);
        
        } catch (error) {
            switch (error.status) {
                case 422:
                    emit('update:rover_message', error.response.data.message);
                    break;
            
                default:
                    emit('update:rover_message', error.response.data.error);
                    break;
            }
        }
    }



    onMounted(() => {
        fetchRovers();
    });

</script>

<template>

    <div>
        <h2>Select Rover</h2>
        <select name="rover" id="rover" @change="roverSelected" v-model="local_rover_selected">
            <option disabled>Select rover</option>
            <option v-for="rover in rover_list" :value="rover.id">
                {{ rover.name }}
            </option>
        </select>
        <p>{{ props.get_rover_message }}</p>
    </div>

</template>