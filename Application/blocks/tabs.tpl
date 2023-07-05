[{$smarty.block.parent}]
[{assign var="aSustainabilityDatas" value=$oView->fcGetSustainabilityDataById($oDetailsProduct)}]
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let siblingElement = document.getElementById('description');
        siblingElement.insertAdjacentElement("afterend", document.getElementById('sustainabilityDiv'));
        document.getElementById('sustainabilityDiv').style.display = '';
    });

</script>
<div style="display: none" id="sustainabilityDiv">
    [{foreach from=$aSustainabilityDatas item=aSustainabilityData}]
        <h2>[{$oView->fcGetSustainabilityTitle($aSustainabilityData)}]</h2>
        <a [{if $oView->fcGetSustainabilityLink($aSustainabilityData) !== ''}] target="_blank" href="[{$oView->fcGetSustainabilityLink($aSustainabilityData)}] [{/if}]">
            <img src="[{$oView->fcGetSustainabilityImageUrl($aSustainabilityData)}]">
        </a>
    [{/foreach}]
</div>
