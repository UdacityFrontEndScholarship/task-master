<form>

    <div class="row">

        <div class="input-field col s12 m12 l12 xl12">
          <input id="institute" type="text" class="validate">
          <label for="institute">Title</label>
        </div>

        <div class="input-field col s12 m12 l12 xl12">
          <textarea id="description" class="materialize-textarea"></textarea>
          <label for="description">Description</label>
        </div>

        <div class="input-field col s12 m6 l6 xl6">
          <select>
            <option value="" disabled selected>Choose your option</option>
            <option value="1">HIGH</option>
            <option value="2">MODERATE</option>
            <option value="3">LOW</option>
          </select>
          <label>Task Priority</label>
        </div>

        <div class="input-field col s12 m6 l6 xl6">
          <select>
            <option value="" disabled selected>Choose your option</option>
            <option value="1">Daily</option>
            <option value="2">Weekly</option>
            <option value="3">Monthly</option>
          </select>
          <label>Alarm Type</label>
        </div>

        <div class="input-field col s12 m6 l6 xl6">
          <input type="date" name="">
          <label for="">Deadline Date</label>
        </div>

        <div class="input-field col s12 m6 l6 xl6">
          <input type="time" name="">
          <label for="">Alarm time</label>
        </div>

    </div> <!---row-->

    <div class="row center-align">
        <button class="btn modal-close teal">Add<i class="material-icons right modal-close">send</i></button>
    </div>

</form>
