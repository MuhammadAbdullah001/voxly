$("#add_item_invoice").click(function () {
    if (typeof $count === ('undefined')) {
        $count = 1;
    }
    $count++;
    var prepend_section = $('<tr><td>\n' +
        ($count) +
        '</td>' +
        '<td>' +
        '<input type="text" name="item_name[]" id="item_name[]" class="form-control" placeholder="Item Name" required>' +
        '</td>' +
        // '<td>' +
        // '<input type="number" name="item_quantity[]" id="item_quantity[]" class="form-control" placeholder="Quantity" required>' +
        // '</td>' +
        '<td>' +
        '<input type="number" min="0" name="item_price[]" id="item_price[]" class="form-control" placeholder="Price" required>' +

        '</td>'
        // +
        // '<td>' +
        // '<span class="total_price" name="item_total[]" id="item_total[]"></span> PKR\n' +
        // '</td>'
    );

    var removeButton = $("<td> <button type=\"button\" class=\"btn btn-danger invoice_item_delete\" ><i class=\"icon-cross\"></i></button> </td></tr>");
    removeButton.click(function () {
        $(this).parent().remove();
    });
    prepend_section.append(removeButton);
    $('#invoice_items_table  > tbody').append(prepend_section);
    return false;
});