{extends file="parent:frontend/account/order_item_details.tpl"}

{block name="frontend_account_order_item_user_comment"}
    <div class="panel--tr is--odd">
        <div class="panel--td column--swark-labels">
            <p class="is--strong">{s name="transaction_label"}Ark Transaction:{/s}</p>
        </div>
        <div class="panel--td column--swark-data">
            <p>
                <a href="{$offerPosition.swarkExplorerUrl}">{s name="transaction_url_label"}View on Explorer{/s}</a>
            </p>
        </div>
    </div>

    {$smarty.block.parent}
{/block}