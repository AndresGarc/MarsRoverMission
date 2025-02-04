<script setup>
    import {ref} from 'vue';
    import axios from 'axios';

    const sequence = ref('');
    const sequence_outcome_message = ref('');

    const props = defineProps(['rover_selected']);
    const emit = defineEmits(['update:rover_message']);


    const validateForm = () => {
        if (props.rover_selected === null) {
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
            const response = await axios.post('rover/' + props.rover_selected + '/move', {
                sequence: sequence.value
            });

            //Change response to add the next message to detail column
            sequence_outcome_message.value = response.data.details;
            emit('update:rover_message', 'Rover ' + props.rover_selected + ': (' + response.data.row + ',' + response.data.column + '), ' + response.data.direction);

        } catch (error) {
            switch (error.status) {
                case 422:
                    sequence_outcome_message.value = error.response.data.message;
                    break;
            
                default:
                    sequence_outcome_message.value = error.response.data.error;
                    emit('update:rover_message', 'Rover ' + rover_selected.value + ': (' + response.data.row + ',' + response.data.column + '), ' + response.data.direction); 
                    break;
            }
        }
    }
</script>

<template>
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