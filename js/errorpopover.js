/**
 * Adds client-side forms validation as Bootstrap's Popovers.
 */
function afterValidateAttribute(form, attribute, data, hasError)
{

    var field = (attribute.hasOwnProperty('id')) ? attribute['id'] : '';
 
    if(field !== '')
    {
        var text = (data.hasOwnProperty(field)) ? data[field] : '';
        field = '#' + field;
        if(hasError && (text !== ''))
        {
            var
                tTemp = '',
                dotTemp = '';
 
            /**
             * We use a trick with temporary disabling title, if user is also 
             * using tooltip for this field. Our popover would share title used 
             * in that tooltip, which is rather unwanted effect, right?
             */
            if($(field).attr('rel') == 'tooltip')
            {
                tTemp = $(field).attr('title');
                dotTemp = $(field).attr('data-original-title');
 
                $(field).attr('title', '');
                $(field).attr('data-original-title', '');
            }
 
            /**
             * 'destroy' is necessary here, if your field can have more than one
             * validation error text, for example, if e-mail field can't be empty
             * and entered value must be a valid e-mail; in such cases, not using
             * .popover('destroy') here would result in incorrect validation errors
             * being displayed for such field.
             */    
            $(field)
                .popover('destroy')
                .popover
                ({
                    trigger : 'manual',
                    content : text
                })
                .popover('show');
 
            if($(field).attr('rel') == 'tooltip')
            {
                $(field).attr('title', tTemp);
                $(field).attr('data-original-title', dotTemp);
            }
        }
        else $(field).popover('destroy');
    }
}