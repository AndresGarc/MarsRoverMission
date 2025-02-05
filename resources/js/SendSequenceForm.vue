<script setup>
    import {ref, watch} from 'vue';
    import axios from 'axios';

    const sequence = ref('');
    const sequence_outcome_message = ref('');
    const loading = ref(false);

    const props = defineProps(['rover_selected']);
    const emit = defineEmits(['update:rover_message']);

    watch(() => props.rover_selected, () => sequence_outcome_message.value = '');
    
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
        loading.value = true;
        if (!validateForm()) {
            loading.value = false;
            return;
        }
        
            //add loader icon
        await axios.post('rover/' + props.rover_selected + '/move', {
            sequence: sequence.value
        })
        .then(function(response) {
            loading.value = false;
            sequence_outcome_message.value = response.data.details;
            emit('update:rover_message', 'Rover ' + props.rover_selected + ': (' + response.data.row + ',' + response.data.column + '), ' + response.data.direction);
        })
        .catch(function (error) {
            loading.value = false;
            switch (error.status) {
                case 422:
                    sequence_outcome_message.value = error.response.data.message;
                    break;
            
                default:
                    sequence_outcome_message.value = error.response.data.error;
                    emit('update:rover_message', 'Rover ' + rover_selected.value + ': (' + response.data.row + ',' + response.data.column + '), ' + response.data.direction); 
                    break;
            }
        });
    }
</script>

<template>
    <form @submit.prevent="sendSequence">
        
        <div class="mb-4">
            <label for="sequence" class="block mb-2 font-semibold">Send a command sequence to move the selected rover</label>
            <input type="text" id="sequence" v-model="sequence" required
                class="w-full mb-2 rounded border-neutral-400 focus:border-red-900 focus:focus:ring-red-900"
            />
            <p class="text-sm text-neutral-600">Important: the use commands F, R or L to move</p>
            <svg v-if="loading" class="mr-3 -ml-1 size-5 animate-spin text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="mt-4">{{ sequence_outcome_message }}</p>
        </div>
        

        <button type="submit" class="px-4 py-2 bg-black text-white rounded transition hover:bg-neutral-700">
            Send
        </button>

    </form>
</template>