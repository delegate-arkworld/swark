{extends file="parent:frontend/checkout/finish.tpl"}

{block name="frontend_index_header_javascript"}
    {$smarty.block.parent}

    {block name="frontend_checkout_finish_swark_js"}
        <script src='https://unpkg.com/ark-qrcode@latest/dist/arkqrcode.js'></script>
    {/block}
{/block}

{block name="frontend_checkout_finish_teaser_actions"}
    {$smarty.block.parent}

    {* TODO: modify styling *}
    {* TODO: add snippets after styling *}
    {block name="frontend_checkout_finish_swark_container"}
        <div class="swark-container">
            {block name="frontend_checkout_finish_swark_headline"}
                <h3>{s name="headline"}Pay with ARK!{/s}</h3>
            {/block}
            {block name="frontend_checkout_finish_swark_description"}
                <div class="swark-container-payment-description">
                    {block name="frontend_checkout_finish_swark_description_qrcode_headline"}
                        <h4>{s name="qrcode_headline"}Use the QR-Code with the official ARK Mobile App:{/s}</h4>
                    {/block}
                    {block name="frontend_checkout_finish_swark_description_qrcode_code"}
                        <ark-qrcode
                                address="{$swarkAttributes.swarkRecipient}"
                                amount="{$swarkAttributes.swarkArkAmount}"
                                vendor-field="{$swarkAttributes.swarkVendorField}"
                                size="200"
                                show-logo="true">
                        </ark-qrcode>
                    {/block}
                    {block name="frontend_checkout_finish_swark_description_manual_headline"}
                        <h4>{s name="manually_headline"}Send the Transaction manually:{/s}</h4>
                    {/block}
                    {block name="frontend_checkout_finish_swark_description_manual_content"}
                        <p>
                            {s name="manually_label_address"}Address{/s} {$swarkAttributes.swarkRecipient}<br />
                            {s name="manually_label_amount"}Amount{/s} {$swarkAttributes.swarkArkAmount} ARK<br />
                            {s name="manually_label_vendorField"}Vendorfield{/s} {$swarkAttributes.swarkVendorField}
                        </p>
                    {/block}
                </div>
            {/block}
            {block name="frontend_checkout_finish_swark_information"}
                <div class="swark-container-payment-information">
                    <p>{s name="confirmations_info"}Your transaction need at least <b>{$swarkConfirmations} confirmations</b> to be accepted!{/s}</p>
                </div>
            {/block}
        </div>
    {/block}
{/block}
