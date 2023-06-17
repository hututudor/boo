import { deleteReview, getMyReviews } from '../api';
import {
  getReviewNode,
  hideModal,
  renderSidebar,
  showModal,
} from '../components';

const pageState = {
  reviewId: 0,
};

export const load = async () => {
  renderSidebar();
  registerModalEvents();

  await displayReviews();
};

const displayReviews = async () => {
  const reviews = await getMyReviews();

  const reviewsNode = document.getElementsByClassName('reviews')[0];
  reviewsNode.innerHTML = '';
  reviews.forEach(review =>
    reviewsNode.appendChild(
      getReviewNode(review, showDeleteReview(review.id), false),
    ),
  );
};

const registerModalEvents = () => {
  document
    .getElementById('delete-modal-cancel')
    .addEventListener('click', hideDeleteReview);
  document
    .getElementById('delete-modal-delete')
    .addEventListener('click', handleDeleteReview);
};

const showDeleteReview = reviewId => () => {
  pageState.reviewId = reviewId;
  showModal('delete-modal');
};

const hideDeleteReview = () => {
  hideModal('delete-modal');
};

const handleDeleteReview = async () => {
  await deleteReview(pageState.reviewId);
  await displayReviews();
  hideDeleteReview();
};
