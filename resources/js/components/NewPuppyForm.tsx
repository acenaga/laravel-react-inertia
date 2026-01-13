import { useForm } from "@inertiajs/react";
import { store } from "@/routes/puppies";
import { useFormStatus } from "react-dom";



export function NewPuppyForm() {
    const { post, setData, data } = useForm({
        name: '',
        trait: '',
        image: null as File | null,
    });
    return (
        <div className="mt-12 flex items-center justify-between bg-white p-8 shadow ring ring-black/5 text-slate-700">
            <form
                className="mt-4 flex w-full flex-col items-start gap-4"
                onSubmit={async (e) => {
                    e.preventDefault();
                    post(store().url, {
                        preserveScroll: true,
                    });
                }}
            >
                <div className="grid w-full gap-6 md:grid-cols-3">
                    <fieldset className="flex w-full flex-col gap-1">
                        <label htmlFor="name">Name</label>
                        <input
                            required
                            className="max-w-96 rounded-sm bg-white px-2 py-1 ring ring-black/20 focus:ring-2 focus:ring-cyan-500 focus:outline-none"
                            id="name"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            type="text"
                            name="name"
                        />
                    </fieldset>
                    <fieldset className="flex w-full flex-col gap-1">
                        <label htmlFor="trait">Personality trait</label>
                        <input
                            required
                            className="max-w-96 rounded-sm bg-white px-2 py-1 ring ring-black/20 focus:ring-2 focus:ring-cyan-500 focus:outline-none"
                            id="trait"
                            value={data.trait}
                            onChange={(e) => setData('trait', e.target.value)}
                            type="text"
                            name="trait"
                        />
                    </fieldset>
                    <fieldset
                        className="col-span-2 flex w-full flex-col gap-1"
                    >
                        <label htmlFor="image">Profile pic</label>
                        <input
                            required
                            className="max-w-96 rounded-sm bg-white px-2 py-1 ring ring-black/20 focus:ring-2 focus:ring-cyan-500 focus:outline-none"
                            id="image"
                            type="file"
                            name="image"
                            accept="image/*"
                            onChange={(e) => {
                                setData('image', e.target.files ? e.target.files[0] : null);
                            }}
                        />
                    </fieldset>
                </div>
                <SubmitButton />
            </form>
        </div>
    )
}

function SubmitButton() {
    const status = useFormStatus();
    return (
        <button
            className="mt-4 inline-block rounded bg-cyan-300 px-4 py-2 font-medium text-cyan-900 hover:bg-cyan-200 focus:ring-2 focus:ring-cyan-500 focus:outline-none disabled:bg-slate-200 disabled:cursor-not-allowed"
            type="submit"
            disabled={status.pending}
        >
            {status.pending ? `Adding ${status?.data?.get("name") || 'puppy'}...` : "Add puppy"}
        </button>
    )
}
