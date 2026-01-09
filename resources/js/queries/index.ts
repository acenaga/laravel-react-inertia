import { Puppy } from "../types";


export async function toggleLikeStatus(id: Puppy["id"]){
    try{
        const response = await fetch(`http://react-from-scratch-api.test/api/puppies/${id}/like`,{
            method: 'PATCH',
            headers: {
                'Accept': 'application/json'
            }
        });
        if (!response.ok) {
            const errorData = await response.json();
            throw errorData
        }
        const {data} = await response.json();
        return data;
    } catch (error) {
        console.error('Error toggling like status:', error);
        throw error;
    }
}

export async function createPuppy(formData: FormData) {
    try{
        const response = await fetch(`http://react-from-scratch-api.test/api/puppies`,{
            method: 'POST',
            headers: {
                'Accept': 'application/json',
            },
            body: formData
        });
        if (!response.ok) {
            const errorData = await response.json();
            throw errorData
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error creating puppy:', error);
        return error;
    }
}
