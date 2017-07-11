<v-layout row wrap class="text-input">
    <v-flex xs12>
        <v-text-field
                light
                name="{{$input_id}}"
                label="{{$placeholder}}"
                id="{{$input_id}}"
                v-model="@if(empty($type)){{'text'}}@else{{$type}}@endif"

        ></v-text-field>
    </v-flex>
</v-layout>