<table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
    <tbody>
        <tr class="form-field">
            <th valign="top" scope="row">
                <label for="quote_text">Quote</label>
                <p>Max: 255</p>
            </th>
            <td>
                <div class="col-lg-10">
                    <textarea maxlength="254" class="form-control" name="quote_text" id="quote_text" cols="20" rows="3" placeholder="Enter the quote"><?php echo esc_attr($item['quote_text']) ?></textarea>
                </div>
            </td>
        </tr>
        <tr class="form-field">
            <th valign="top" scope="row">
                <label for="quote_author">Author</label>
            </th>
            <td>
                <input id="quote_author" name="quote_author" type="text" style="width: 95%" value="<?php echo esc_attr($item['quote_author']) ?>" size="50" class="code" placeholder="Author" required>
            </td>
        </tr>
    </tbody>
</table>