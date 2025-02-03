<script setup>
    import {ref, onMounted} from 'vue';
    import axios from 'axios';

    const rover_list = ref([]);
    const rover_selected = ref(null);
    const get_rover_message = ref('');
    const sequence = ref('');
    const sequence_outcome_message = ref('');


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
            const response = await axios.get('rover/' + rover_selected.value + '/position');
            get_rover_message.value = 'Rover ' + rover_selected.value + ': (' + response.data.row + ',' + response.data.column + '), ' + response.data.direction; 
            
        } catch (error) {
            switch (error.status) {
                case 422:
                    get_rover_message.value = error.response.data.message;
                    break;
            
                default:
                    get_rover_message.value = error.response.data.error;
                    break;
            }
        }
    }

    const validateForm = () => {
        if (rover_selected.value === null) {
            sequence_outcome_message.value = 'Select a rover first';
            return false;
        }

        if (sequence.value === null) {
            sequence_outcome_message.value = 'The sequence is required';
            return false;
        }

        if (!/^[FLR]+$/.test(sequence.value)) {
            sequence_outcome_message.value = 'The sequence must have only F, R, L with uppercase letters';
            return false;
        }

        return true;
    }

    const sendSequence = async() => {
        
        if (!validateForm()) return;
        
        try {
            //add loader icon
            const response = await axios.post('rover/' + rover_selected.value + '/move', {
                sequence: sequence.value
            });

            //Change response to add the next message to detail column
            sequence_outcome_message.value = 'Rover moved correctly to: (' + response.data.row + ',' + response.data.column + '), ' + response.data.direction;
            get_rover_message.value = 'Rover ' + rover_selected.value + ': (' + response.data.row + ',' + response.data.column + '), ' + response.data.direction; 

        } catch (error) {
            switch (error.status) {
                case 422:
                    sequence_outcome_message.value = error.response.data.message;
                    break;
            
                default:
                    sequence_outcome_message.value = error.response.data.error;
                    get_rover_message.value = 'Rover ' + rover_selected.value + ': (' + response.data.row + ',' + response.data.column + '), ' + response.data.direction; 
                    break;
            }
        }
    }

    onMounted(() => {
        fetchRovers();
    });

</script>

<template>
    
  
    <header>
        <h1>Mars Rover Mission</h1>
    </header>

    <div>
        <h2>Select Rover</h2>
        <select name="rover" id="rover" @change="roverSelected" v-model="rover_selected">
            <option disabled>Select rover</option>
            <option v-for="rover in rover_list" :value="rover.id">
                {{ rover.name }}
            </option>
            <option value="4">Rover 4</option>
        </select>
        <p>{{ get_rover_message }}</p>
    </div>

    <form @submit.prevent="sendSequence">
        
        <div>
            <label for="sequence">Send a command sequence to move the selected rover</label>
            <br>
            <input type="text" id="sequence" v-model="sequence" required />
            <p>Important: the use commands F, R or L to move</p>
            <p>{{ sequence_outcome_message }}</p>
        </div>
        

        <button type="submit">
            Send
        </button>

    </form>

</template>