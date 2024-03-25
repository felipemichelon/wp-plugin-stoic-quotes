<table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
    <tbody>
        <tr class="form-field">
            <th valign="top" scope="row">
                <label for="quote_text"><?php echo esc_attr(__('Quote', 'random-stoic-quotes')); ?></label>
            </th>
            <td>
                <div class="col-lg-10">
                    <label for="quote_text">Max. 255</label>
                    <textarea maxlength="254" class="form-control" name="quote_text" id="quote_text" cols="20" rows="3" placeholder="<?php echo esc_attr(__('Enter the quote', 'random-stoic-quotes')); ?>"><?php echo esc_attr($item['quote_text']); ?></textarea>
                </div>
            </td>
        </tr>
        <tr class="form-field">
            <th valign="top" scope="row">
                <label for="quote_author"><?php echo esc_attr(__('Author', 'random-stoic-quotes')); ?></label>
            </th>
            <td>
                <label for="quote_text">Max. 100</label>
                <input maxlength="99" id="quote_author" name="quote_author" type="text" style="width: 95%" value="<?php echo esc_attr($item['quote_author']); ?>" size="50" class="code" placeholder="<?php echo esc_attr(__('Enter the author', 'random-stoic-quotes')); ?>" required>
            </td>
        </tr>
    </tbody>
</table>