{block name='frontend_checkout_finish_teaser_actions'}
    {$smarty.block.parent}

    {* TODO: add blocks for easy modification *}
    {block name='frontend_checkout_finish_swark_container'}
        <div class="swark-container">
            <h3>Pay with ARK!</h3>
            <div class="swark-container-payment-description">
                <p>
                    Use the QR-Code with the official ARK Mobile App
                </p>
                <ark-qrcode
                        address="{$swarkAttributes.swarkRecipient}"
                        amount="{$swarkAttributes.swarkArkAmount}"
                        vendor-field="{$swarkAttributes.swarkVendorField}"
                        size="200"
                        show-logo="true">
                </ark-qrcode>
                <p>
                    OR
                </p>
                <p>
                    send the amount of <b>{$swarkAttributes.swarkArkAmount} ARK</b> with the vendorField
                    <b>{$swarkAttributes.swarkVendorField}</b> to the following address: <b>{$swarkAttributes.swarkRecipient}</b>
                </p>
            </div>
            <div class="swark-container-payment-information">
                <p>Your transaction need at least <b>{$swarkConfirmations} confirmations</b>!</p>
            </div>
        </div>
    {/block}
{/block}