<div class="king-form-group">
    <label class="king-label">Enable Subtitles</label>
    <div class="king-checkbox">
        <input type="checkbox" id="subs"
            wire:click="toggleSubs"
            value="{{ $subs_enabled }}"
            @if($subs_enabled) checked @endif
            style="width: 20px; height: 20px; margin-top: 10px; margin-left: 10px; background-color: #fff;">
    </div>
</div>
