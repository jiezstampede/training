<script id="asset-image-template" type="text/x-handlebars-template">
	<div class="sumo-asset-img-container @{{ visibility }}" data-id="@{{ id }}">
		<img src="@{{ src }}">
		<div class="sumo-asset-img-hover-overlay"><ul>
			<li><a href="#" class="preview" data-toggle="tooltip" title="Preview"><i class="fa fa-eye"></i></a></li>
			<li><a href="#" class="remove" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a></li>
		</ul></div>
	</div>
</script>
<script id="asset-multiple-image-template" type="text/x-handlebars-template">
    <div class="images-container row">
        <div class="empty-bg @{{ visibility }}">
            <i class="fa fa-image"></i>
        </div>
        @{{#if images}}
        	@{{#each images}}
            <div class="col col-xs-4 col-sm-3 box-container sumo-asset-select">
                <div class="sumo-asset-img-container" data-id="@{{ this.asset_id }}">
                    <img src="@{{ this.src }}">
                    <div class="sumo-asset-img-hover-overlay"><ul>
                        <li><a href="#" class="preview" data-toggle="tooltip" title="Preview"><i class="fa fa-eye"></i></a></li>
                        <li><a href="#" class="remove" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a></li>
                    </ul></div>
                </div>
            </div>
            @{{/each}}
        @{{/if}}
    </div>
</script>
<script id="asset-image-for-gallery-template" type="text/x-handlebars-template">
    @{{#if images}}
        @{{#each images}}
            <div class="col-xs-4 col-sm-3">
                <div class="sumo-asset-image-container thumbnail">
                    <img class="img img-responsive" src="@{{ this }}">
                </div>
            </div>
        @{{else}}
            <div class="col-xs-4 col-sm-3">
                <div class="sumo-asset-image-container thumbnail">
                    <img class="img img-responsive" src="@{{ images }}">
                </div>
            </div>
        @{{/each}}
    @{{/if}}
</script>
<input disabled readonly type="hidden" value="{!! route('adminAssetsGet') !!}" id="adminAssetsGetUrl">