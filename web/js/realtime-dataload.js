function showModal({ message }) {
  const modal = $("#cartModal");
  modal
    .find(".modal-content")
    .html(
      '<div class="modal-body text-center"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="pe-7s-close"></i></button><div class="tt-modal-messages"> <i class="pe-7s-check"></i>' +
        message +
        "</div></div>",
    );
  modal.modal("show");
}


window.changeCartItemCount = (function ({ cartItemsCount }) {
  const cartCount = $(".header-action-num");
  cartCount.text(cartItemsCount);
})

$(document).on("htmx:afterOnLoad", function handleHtmxAfterOnLoad(event) {
  const contentType = event.detail.xhr
    .getResponseHeader("Content-Type")
    .split(";")[0];
  const response = event.detail.xhr.response;

  console.log(response);
  let data;
  if (contentType === "application/json") {
    data = JSON.parse(response);
  } else if (contentType === "text/html") {
    const parser = new DOMParser();
    const doc = parser.parseFromString(response, "text/html");
    const fragment = document.createDocumentFragment();
    fragment.appendChild(doc.body);

    const wrapper = fragment.querySelector("[data-id]");
    if (wrapper) {
      data = {
        id: wrapper.dataset.id,
        action: wrapper.dataset.action,
        wishlistItemsCount: wrapper.dataset.wishlistitemscount,
        cartItemsCount: wrapper.dataset.cartitemscount,
      };
    } else {
      data = {};
    }

  }

  const heartIconSvg = `
    <svg class="wishlist-icon-${data.id}" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="red"/>
    </svg>
  `;

  const likeButton = $(".wishlist-icon-" + data.id);
  const likeButtonHtml = `<i class="pe-7s-like wishlist-icon-${data.id}"></i>`;

  switch (data.action) {
    case "addToWishlist":
      likeButton.replaceWith(heartIconSvg);
      break;

    case "removeFromWishList":
      likeButton.replaceWith(likeButtonHtml);
      // user is in the wishlist page
      if (window.removeFromWishList) {
        removeFromWishList({
          id: data.id,
          wishlistItemsCount: data.wishlistItemsCount,
        });
      } 
      break;

    case "removeFromCart":
      const removedCartItem = $(".cartitem-" + data.id);
        
      // user is in the cart page
      if (window.changeCartTotal) {
        changeCartTotal(
          { cartGrandTotal: data.cartGrandTotal, cartTotal: data.cartTotal },
          data.cartItemsCount,
        );
      }
      changeCartItemCount({ cartItemsCount: data.cartItemsCount });
      removedCartItem.slideUp();
      break;

    case "applyCoupon":
      const {
        coupon,
        couponDiscountAmountAsCurrency,
        cartGrandTotal,
        errorCode,
      } = JSON.parse(response);
      if (errorCode) {
        switch (errorCode) {
          case "NotFound":
            alert("Coupon not found");
            break;
          case "NotActive":
            alert("This coupon is invalid");
            break;
          default:
            console.error("Unknown coupon error:", errorCode);
        }
      }

      // user is in the checkout page
      if (window.applyCoupon) {
        applyCoupon({ coupon, couponDiscountAmountAsCurrency, cartGrandTotal })
      };
      break;

    case "createUserAddress":
      var { ok, model, message } = JSON.parse(response);
      showModal({ message });
      
      // user is in the account page
      if (window.insertNewBillingAddress && ok) {
        insertNewBillingAddress(model);
      }
      break;

    case "removeUserAddres":
      var { ok, id, message } = JSON.parse(response);

      showModal({ message });

      // user is in the account page
      if (window.removeFromBillingAddress && ok) {
        removeBillingAddress(id);
      }

      break;
    case "addToCart":
      changeCartItemCount({ cartItemsCount: data.cartItemsCount });
      break;

    case "viewProduct":
      console.log('hello', data.data);
      break; 

    // ADMIN ACTIONS
    
    case "updateSpecification":
      var { ok, message } = JSON.parse(response);
      alert('updated')
      break;

    case "removeSpecification":
      var { ok, message, id } = JSON.parse(response);
      $('.specification-' + id).remove();
      break;
  }
  window.handleHtmxAfterOnLoad = handleHtmxAfterOnLoad;
});
