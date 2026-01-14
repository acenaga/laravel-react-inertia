import { useForm } from "@inertiajs/react";
import { store } from "@/routes/puppies";
import { useFormStatus } from "react-dom";
import { useRef } from "react";



export function NewPuppyForm( { mainRef }: { mainRef?: React.RefObject<HTMLElement> }) {
    const { post, setData, data, errors, reset, processing } = useForm({
        name: '',
        trait: '',
        image: null as File | null,
    });
    const fileInputRef = useRef<HTMLInputElement>(null);
    return (
        <div className="mt-12 flex items-center justify-between bg-white p-8 shadow ring ring-black/5 text-slate-700">
            <form
                className="mt-4 flex w-full flex-col items-start gap-4"
                onSubmit={async (e) => {
                    e.preventDefault();
                    post(store().url, {
                        preserveScroll: true,
                        onSuccess: () => {
                            reset();
                            if (fileInputRef.current) {
                                fileInputRef.current.value = '';
                            }
                            if (mainRef?.current) {
                                mainRef.current.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            }
                        },
                    });
                }}
            >
                <div className="grid w-full gap-6 md:grid-cols-3">
                    <fieldset className="flex w-full flex-col gap-1">
                        <label htmlFor="name">Name</label>
                        <input
                            // required
                            className="max-w-96 rounded-sm bg-white px-2 py-1 ring ring-black/20 focus:ring-2 focus:ring-cyan-500 focus:outline-none"
                            id="name"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            type="text"
                            name="name"
                        />
                        {errors.name && <p className="text-xs mt-1 text-red-600">{errors.name}</p>}
                    </fieldset>
                    <fieldset className="flex w-full flex-col gap-1">
                        <label htmlFor="trait">Personality trait</label>
                        <input
                            // required
                            className="max-w-96 rounded-sm bg-white px-2 py-1 ring ring-black/20 focus:ring-2 focus:ring-cyan-500 focus:outline-none"
                            id="trait"
                            value={data.trait}
                            onChange={(e) => setData('trait', e.target.value)}
                            type="text"
                            name="trait"
                        />
                        {errors.trait && <p className="text-xs mt-1 text-red-600">{errors.trait}</p>}
                    </fieldset>
                    <fieldset
                        className="col-span-2 flex w-full flex-col gap-1"
                    >
                        <label htmlFor="image">Profile pic</label>
                        <input
                            // required
                            ref={fileInputRef}
                            className="max-w-96 rounded-sm bg-white px-2 py-1 ring ring-black/20 focus:ring-2 focus:ring-cyan-500 focus:outline-none"
                            id="image"
                            type="file"
                            name="image"
                            accept="image/*"
                            onChange={(e) => {
                                setData('image', e.target.files ? e.target.files[0] : null);
                            }}
                        />
                        {errors.image && <p className="text-xs mt-1 text-red-600">{errors.image}</p>}
                    </fieldset>
                </div>
                <button
                    className="mt-4 inline-block rounded bg-cyan-300 px-4 py-2 font-medium text-cyan-900 hover:bg-cyan-200 focus:ring-2 focus:ring-cyan-500 focus:outline-none disabled:bg-slate-200 disabled:cursor-not-allowed"
                    type="submit"
                    disabled={processing}
                >
                    {processing ? `Adding ${data.name}...` : "Add puppy"}
                </button>
            </form>
        </div>
    )
}
