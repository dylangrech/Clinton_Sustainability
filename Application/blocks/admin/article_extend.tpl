<input id="fcSustainabilityButton" [{$readonly}] type="button" value="[{oxmultilang ident="CLINTON_SUSTAINABILITY_MAIN_ASSIGN"}]" class="edittext" onclick="JavaScript:showDialog('&cl=article_extend&aoc=3&oxid=[{$oxid}]');">
<script>
    let fcSustainabilityButton = document.getElementById('fcSustainabilityButton');
    let fcParentElement = fcSustainabilityButton.parentElement.parentElement;
    let fcSiblingElement = fcParentElement.children[0];
    if (fcSustainabilityButton) {
        fcSiblingElement.insertAdjacentElement("afterend", fcSustainabilityButton);
    }
</script>
[{$smarty.block.parent}]