{extends file="parent:frontend/checkout/finish.tpl"}

{block name="frontend_index_header_javascript"}
    {$smarty.block.parent}

    {block name="frontend_checkout_finish_swark_js"}
        <script src='https://unpkg.com/ark-qrcode@latest/dist/arkqrcode.js'></script>
    {/block}
{/block}

{block name="frontend_checkout_finish_teaser_actions"}
    {$smarty.block.parent}

    {block name="frontend_checkout_finish_swark_container"}
        <div class="swark-container">
            {block name="frontend_checkout_finish_swark_headline"}
                <h3>{s name="headline"}Pay with Ark!{/s}</h3>
            {/block}
            {block name="frontend_checkout_finish_swark_description"}
                <p class="swark-container-payment-description">
                    {block name="frontend_checkout_finish_swark_description_qrcode_code"}
                        <ark-qrcode
                                address="{$swarkAttributes.swarkRecipientAddress}"
                                amount="{$swarkAttributes.swarkArkAmount}"
                                vendor-field="{$swarkAttributes.swarkVendorField}"
                                size="200"
                                show-logo="true">
                        </ark-qrcode>
                    {/block}
                    {block name="frontend_checkout_finish_swark_description_manual_content"}
                        <p>
                            <strong>{s name="manually_label_address"}Address{/s}</strong><br />
                            {$swarkAttributes.swarkRecipientAddress}
                        </p>
                        <p>
                            <strong>{s name="manually_label_amount"}Amount{/s}</strong><br />
                            {$swarkAttributes.swarkArkAmount} Ark
                        </p>
                        <p>
                            <strong>{s name="manually_label_vendorField"}Vendorfield{/s}</strong><br />
                            {$swarkAttributes.swarkVendorField}
                        </p>
                    {/block}
                </div>
            {/block}
            {block name="frontend_checkout_finish_swark_information"}
                <div class="swark-container-payment-information">
                    <p>{s name="confirmations_info"}Your transaction need at least <strong>{$swarkConfirmations} Confirmations</strong> to be accepted!{/s}</p>
                </div>
            {/block}
        </div>
    {/block}
{/block}
