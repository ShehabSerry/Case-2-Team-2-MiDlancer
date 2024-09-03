<div class="yousab">
							<p class="rtext align-self-end
							border mb-1" id="farah">
                            ${response.message}
                            <a href="javascript:void()" onclick="chkalert(${response.chat_id}, ${response.freelancer_id})">delete</a>
                            <a href="javascript:void()" onclick="openEditPopup(${response.chat_id}, '${response.message}')">edit</a>
                            <div class="popup edit-popup" id="edit-popup-${response.chat_id}">
                                <h3>Edit Message</h3>
                                <form onsubmit="event.preventDefault(); save(${response.chat_id}, ${response.freelancer_id});">
                                    <textarea id="edit-message-${response.chat_id}" class="form-control">${response.message}</textarea>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-secondary" onclick="closeEditPopup(${response.chat_id})">Cancel</button>
                                </form>
                            </div>
                            <small class="d-block">${response.created_at}</small>
                        </p>
						</div>`;