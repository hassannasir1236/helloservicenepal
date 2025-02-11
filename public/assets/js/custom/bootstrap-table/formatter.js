function imageFormatter(value) {
    if (value) {
        return '<a class="image-popup-no-margins one-image" href="' + value + '">' +
            '<img class="rounded avatar-md shadow img-fluid " alt="" src="' + value + '" width="55" onerror="onErrorImage(event)">' +
            '</a>'
    } else {
        return '-'
    }
}

function galleryImageFormatter(value) {
    if (value) {
        let html = '<div class="gallery">';
        $.each(value, function (index, data) {
            html += '<a href="' + data.image + '"><img class="rounded avatar-md shadow img-fluid m-1" alt="" src="' + data.image + '" width="55" onerror="onErrorImage(event)"></a>';
        })
        html += "</div>"
        return html;
    } else {
        return '-'
    }
}

function subCategoryFormatter(value, row) {
    let url = `/category/${row.id}/subcategories`;
    return '<span> <div class="category_count">' + value + ' Sub Categories</div></span>';
}

function customFieldFormatter(value, row) {
    let url = `/category/${row.id}/custom-fields`;
    return '<a href="' + url + '"> <div class="category_count">' + value + ' Custom Fields</div></a>';

}

function statusSwitchFormatter(value, row) {
    return `<div class="form-check form-switch">
        <input class = "form-check-input switch1 update-status" id="${row.id}" type = "checkbox" role = "switch${status}" ${value ? 'checked' : ''}>
    </div>`
}

function itemStatusSwitchFormatter(value, row) {
    return `<div class="form-check form-switch">
        <input class = "form-check-input switch1 update-item-status" id="${row.item_id}" type = "checkbox" role = "switch${status}" ${value ? 'checked' : ''}>
    </div>`
}

function userStatusSwitchFormatter(value, row) {
    return `<div class="form-check form-switch">
        <input class = "form-check-input switch1 update-user-status" id="${row.user_id}" type = "checkbox" role = "switch${status}" ${value ? 'checked' : ''}>
    </div>`
}


function itemStatusFormatter(value) {
    let badgeClass, badgeText;
    if (value == "review") {
        badgeClass = 'primary';
        badgeText = 'Under Review';
    } else if (value == "approved") {
        badgeClass = 'success';
        badgeText = 'Approved';
    } else if (value == "rejected") {
        badgeClass = 'danger';
        badgeText = 'Rejected';
    } else if (value == "sold out") {
        badgeClass = 'warning';
        badgeText = 'Sold Out';
    } else if (value == "featured") {
        badgeClass = 'black';
        badgeText = 'Featured';
    } else if (value == "inactive") {
        badgeClass = 'danger';
        badgeText = 'Inactive';
    }
    return '<span class="badge rounded-pill bg-' + badgeClass + '">' + badgeText + '</span>';
}

function status_badge(value, row) {
    let badgeClass, badgeText;
    if (value == '0') {
        badgeClass = 'danger';
        badgeText = 'OFF';
    } else {
        badgeClass = 'success';
        badgeText = 'ON';
    }
    return '<span class="badge rounded-pill bg-' + badgeClass + '">' + badgeText + '</span>';
}

function userStatusBadgeFormatter(value, row) {
    let badgeClass, badgeText;
    if (value == '0') {
        badgeClass = 'danger';
        badgeText = 'Inactive';
    } else {
        badgeClass = 'success';
        badgeText = 'Active';
    }
    return '<span class="badge rounded-pill bg-' + badgeClass + +'">' + badgeText + '</span>';
}

function styleImageFormatter(value, row) {
    return '<a class="image-popup-no-margins" href="images/app_styles/' + value + '.png"><img src="images/app_styles/' + value + '.png" alt="style_4"  height="60" width="60" class="rounded avatar-md shadow img-fluid"></a>';
}

function filterTextFormatter(value) {
    let filter;
    if (value == "most_liked") {
        filter = "Most Liked";
    } else if (value == "price_criteria") {
        filter = "Price Criteria";
    } else if (value == "category_criteria") {
        filter = "Category Criteria";
    } else if (value == "most_viewed") {
        filter = "Most Viewed";
    }
    return filter;
}

function adminFile(value, row) {
    return "<a href='languages/" + row.code + ".json ' )+' > View File < /a>";
}

function appFile(value, row) {
    return "<a href='lang/" + row.code + ".json ' )+' > View File < /a>";
}

function textReadableFormatter(value, row) {
    let string = value.replace("_", " ");
    return string.charAt(0).toUpperCase() + string.slice(1);
}


function unlimitedBadgeFormatter(value) {
    if (!value) {
        return 'Unlimited';
    }
    return value;
}

function detailFormatter(index, row) {
    let html = []
    $.each(row.translations, function (key, value) {
        html.push('<p><b>' + value.language.name + ':</b> ' + value.description + '</p>')
    })
    return html.join('')
}

function truncateDescription(value, row, index, field) {
    const words = value.split(' ');
    const wordLimit = 20; // Set the word limit as needed
    if (words.length > wordLimit) {
        return words.slice(0, wordLimit).join(' ') + '...';
    }
    return value;
}

function truncateDescription(value, row, index) {
    if (value.length > 100) {
        return '<div class="short-description">' + value.substring(0, 50) +
            '... <a href="#" class="view-more" data-index="' + index + '">View More</a></div>' +
            '<div class="full-description" style="display:none;">' + value +
            ' <a href="#" class="view-more" data-index="' + index + '">View Less</a></div>';
    } else {
        return value;
    }
}

function videoLinkFormatter(value, row, index) {
    if (!value) {
        return '';
    }
    const maxLength = 20;
    const displayText = value.length > maxLength ? value.substring(0, maxLength) + '...' : value;
    return `<a href="${value}" target="_blank">${displayText}</a>`;
}

function sellerverificationStatusFormatter(value) {
    let badgeClass, badgeText;
    if (value == "review") {
        badgeClass = 'primary';
        badgeText = 'Under Review';
    } else if (value == "approved") {
        badgeClass = 'success';
        badgeText = 'Approved';
    } else if (value == "rejected") {
        badgeClass = 'danger';
        badgeText = 'Rejected';
    } else if (value == "pending") {
        badgeClass = 'warning';
        badgeText = 'Pending';
    }
    return '<span class="badge rounded-pill bg-' + badgeClass + '">' + badgeText + '</span>';
}


function categoryNameFormatter(value, row, index) {
    let subcategoriesHtml = '';
    if (row.subcategories && row.subcategories.length > 0) {
        subcategoriesHtml = '<ul>';
        row.subcategories.forEach(subcategory => {
            subcategoriesHtml += `<li>${subcategory.name}</li>`;
        });
        subcategoriesHtml += '</ul>';
    }
    return `${value} <button class="btn icon btn-xs btn-rounded btn-icon rounded-pill toggle-subcategories float-left ml-2 btn-outline-primary" style="cursor: pointer;" data-id="${row.id}">
        <i class="fa fa-plus"></i>
    </button>${subcategoriesHtml}`;
}

function descriptionFormatter(value, row, index) {
    if (value.length > 50) {
        return '<div class="short-description">' + value.substring(0, 100) +
            '... <a href="#" class="view-more" data-index="' + index + '">' + trans("View More") + '</a></div>' +
            '<div class="full-description" style="display:none;">' + value +
            ' <a href="#" class="view-more" data-index="' + index + '">' + trans("View Less") + '</a></div>';
    } else {
        return value;
    }
}

